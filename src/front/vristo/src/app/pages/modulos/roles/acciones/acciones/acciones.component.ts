import { Component } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Subscription, forkJoin } from 'rxjs';
import { ErrorModalService } from 'src/app/components/modal/error/error-modal.service';
import { LoadingModalService } from 'src/app/components/modal/loading/loading/loading.service';
import { IAccion } from 'src/app/services/admin/modulos/acciones/IAccion';
import { IRolAccion } from 'src/app/services/admin/modulos/acciones/IRolAccion';
import { AccionesService } from 'src/app/services/admin/modulos/acciones/acciones.service';
import { IRol } from 'src/app/services/admin/modulos/roles/IRol';
import { RolService } from 'src/app/services/admin/modulos/roles/rol.service';

@Component({
  selector: 'app-acciones',
  templateUrl: './acciones.component.html',
  styleUrls: ['./acciones.component.css']
})
export class AccionesComponent {

  listaRoles:IRol[]=[];
  listaAcciones:IAccion[]=[];
  subscritions:Subscription[]=[];
  listRolAcciones:IRolAccion[]=[];
  selectedRol:string="";

  ErrorCommon=(error:any)=>{
    this.loadingModal.closeLoading();  
    this.errorModal.showErrorDialog("Error al procesar la peticion "+ error.error.message);
    console.log(error);
  }

  constructor(private rolesService:RolService, private loadingModal:LoadingModalService,private errorModal:ErrorModalService,private accionesService:AccionesService,private route: ActivatedRoute){}

  showErrorNoSuccess(message:string){
    this.loadingModal.closeLoading();  
    this.errorModal.showErrorDialog("Error al procesar la peticion");
    console.log(message);
  }


  ngOnInit(): void {
    
    this.loadData();    
  }

  ngOnDestroy(): void {
    this.subscritions.forEach((subscription)=>{
      subscription.unsubscribe();
    })
  }

  loadData(){
    this.loadingModal.showLoading();
    this.subscritions.push(forkJoin({
      loadRoles:this.rolesService.GetRoles(),
      loadAcciones:this.accionesService.GetAcciones()
    }).subscribe(
      (resolve)=>{
        if(!resolve.loadRoles.success || !resolve.loadAcciones.success){
          this.showErrorNoSuccess(resolve.loadRoles.message);
          return;
        }
        
        
        this.listaRoles=resolve.loadRoles.data;
        this.listaRoles=this.listaRoles.filter(x=>x.rol!="ADMIN")

        this.subscritions.push(this.route.params.subscribe(
          params=>{
            console.log(params);
            if(params['id']){
              this.selectedRol=params['id']
            }else{
              this.selectedRol=(this.listaRoles[0].publicId) ? this.listaRoles[0].publicId :"";
            }
            
          }
        ))
        
        

        if(this.listaRoles.length<=0) {
          this.loadingModal.closeLoading();
          this.listaRoles.push({
            rol:"Favor de agregar un rol de usuario",
            publicId:"-1",
            activo:true
          });
          return;
        }

        this.listaAcciones=resolve.loadAcciones.data;

        if (this.listaRoles[0]?.publicId){
          this.subscritions.push(this.rolesService.GetAccionesRol(this.selectedRol).subscribe(
            {
              next:(response)=>{
                if(!response.success) this.showErrorNoSuccess(response.message);
                this.listRolAcciones=response.data;
              },
              error:this.ErrorCommon,
              complete:()=>{
                this.loadingModal.closeLoading();
              }
            }
          ));
        }else{
          this.loadingModal.closeLoading();
        } 
      }
    ));
  }

  getSelectedRol(){
    this.loadingModal.showLoading();
    this.subscritions.push(this.rolesService.GetAccionesRol(this.selectedRol).subscribe(
      {
        next:(response)=>{
          if(!response.success) this.showErrorNoSuccess(response.message);
          this.listRolAcciones=response.data;
        },
        error:this.ErrorCommon,
        complete:()=>{
          this.loadingModal.closeLoading();
        }
      }
    ));
  }

  accionCheckEvent($event:any){
    console.log($event);
    console.log(this.selectedRol);
    if($event.checked){
      let request:IRolAccion={
        rolPid:this.selectedRol,
        accionPid:$event.accion.publicId
      }
      this.subscritions.push(this.rolesService.AddRolAccion(request).subscribe({
        next:(response)=>{
          if(!response.success) {
            //todo: change state on the check box to unchecked
          }
          console.log(response);
          this.listRolAcciones.push({
            publicId:response.data.publicId,
            accionPid:request.accionPid,
            rolPid:request.rolPid
          });
        },
        error:(error)=>{
          //todo: change state on the check box to unchecked
        },
        complete:()=>{
          //todo: change state on the check box
        }
      }));
      return;
    }else{
      let item=this.listRolAcciones.filter((item)=> item.rolPid==this.selectedRol && item.accionPid==$event.accion.publicId)[0];
      if(!item.publicId) return;
      this.subscritions.push(this.rolesService.DeleteAccionFromRol(item.publicId).subscribe({
        next:(response)=>{
          if(!response.success) {
            //todo: change state on the check box to unchecked
          }
        },
        error:(error)=>{
          //todo: change state on the check box to unchecked
        },
        complete:()=>{
          //todo: change state on the check box
          this.listRolAcciones = this.listRolAcciones.filter((acciones)=> acciones.publicId!=item.publicId);
        }
      }));
      
    }

  }

}
