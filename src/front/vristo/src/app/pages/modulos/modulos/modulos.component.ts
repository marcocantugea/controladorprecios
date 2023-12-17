import { Component } from '@angular/core';
import { Subscription, forkJoin } from 'rxjs';
import { ErrorModalService } from 'src/app/components/modal/error/error-modal.service';
import { LoadingModalService } from 'src/app/components/modal/loading/loading/loading.service';
import { IRol } from 'src/app/services/admin/modulos/roles/IRol';
import { RolService } from 'src/app/services/admin/modulos/roles/rol.service';
import { IModulo } from 'src/app/services/modulos/IModulo';
import { IRolModulo } from 'src/app/services/modulos/IRolModulo';
import { ModulosService } from 'src/app/services/modulos/modulos.service';

@Component({
  selector: 'app-modulos',
  templateUrl: './modulos.component.html',
  styleUrls: ['./modulos.component.css']
})
export class ModulosComponent {

  listaRoles:IRol[]=[];
  listaModulos:IModulo[]=[];
  selectedRol:string="";
  subscriptions:Subscription[]=[];
  listRolModulos:IRolModulo[]=[];

  ErrorCommon=(error:any)=>{
    this.loadingModal.closeLoading();  
    this.errorModal.showErrorDialog("Error al procesar la peticion "+ error.error.message);
    console.log(error);
  }

  constructor(private rolService:RolService,private moduloService:ModulosService,private loadingModal:LoadingModalService,private errorModal:ErrorModalService){}

  ngOnInit(): void {
    this.loadData();
  }

  ngOnDestroy(): void {
    this.subscriptions.forEach((sub)=>{
      sub.unsubscribe();
    });
  }

  loadData(){
    this.loadingModal.showLoading();
    this.subscriptions.push(forkJoin({
      processLoadListaRoles:this.rolService.GetRoles(),
      rocessLoadModulos:this.moduloService.getModulos()
    }).subscribe(
      (resolve)=>{
        if(!resolve.processLoadListaRoles.success || !resolve.rocessLoadModulos.success){
          this.showErrorNoSuccess(resolve.processLoadListaRoles.message);
          return;
        }

        this.listaRoles=resolve.processLoadListaRoles.data;
        this.listaRoles=this.listaRoles.filter(x=>x.rol!="ADMIN");
        this.selectedRol=(this.listaRoles[0].publicId) ? this.listaRoles[0].publicId : "";
        this.listaModulos=resolve.rocessLoadModulos.data;

        if(this.listaRoles.length<=0) {
          this.loadingModal.closeLoading();
          this.listaRoles.push({
            rol:"Favor de agregar un rol de usuario",
            publicId:"-1",
            activo:true
          });
          this.loadingModal.closeLoading();
          return;
        }

        this.subscriptions.push(this.moduloService.getRolModulos(this.selectedRol).subscribe({
          next:(response)=>{
            if(!response.success) {
              this.showErrorNoSuccess(response.message);
              return;
            }
            this.listRolModulos=response.data;
          },
          error:this.ErrorCommon,
          complete:()=>{
            this.loadingModal.closeLoading();
          }
        }));

      }
    ));

  }

  showErrorNoSuccess(message:string){
    this.loadingModal.closeLoading();  
    this.errorModal.showErrorDialog("Error al procesar la peticion");
    console.log(message);
  }

  getSelectedRol(){
    this.loadingModal.showLoading();
    this.subscriptions.push(this.moduloService.getRolModulos(this.selectedRol).subscribe({
      next:(response)=>{
        if(!response.success){
          this.showErrorNoSuccess(response.message);
          return;
        }

        this.listRolModulos=response.data;
      },
      error:this.ErrorCommon,
      complete:()=>{
        this.loadingModal.closeLoading();
      }
    }));
  }

  accionCheckEvent($event:any){
    console.log($event);
    if($event.checked){
      
      let request:IRolModulo={
        rolPid:this.selectedRol,
        moduloPid:$event.modulo.publicId
      };

      this.subscriptions.push(this.moduloService.addRolModulo(request).subscribe({
        next:(response)=>{
          if(!response.success){
             //todo: change state on the check box to unchecked
            console.log(response.message);
            return;
          }
          
          this.listRolModulos.push({
            publicId:response.data.publicId,
            rolPid:request.rolPid,
            moduloPid:request.moduloPid
          });

        },
        error:(error)=>{
           //todo: change state on the check box to unchecked
        },
        complete:()=>{
           //todo: change state on the check box to green
        }
      }));
    }else{
      let selectedItem= this.listRolModulos.filter((i)=> i.rolPid==this.selectedRol && i.moduloPid==$event.modulo.publicId)[0];
      if(!selectedItem.publicId) return;
      this.subscriptions.push(this.moduloService.deleteRolModulo(selectedItem.publicId).subscribe({
        next:(response)=>{
          if(!response.success){
            //todo: change state on the check box to unchecked
           console.log(response.message);
           return;
         }

        this.listRolModulos= this.listRolModulos.filter((i)=> i.publicId!=selectedItem.publicId);

        },
        error: (error) => {
          //todo: change state on the check box to unchecked
        },
        complete: () => {
          //todo: change state on the check box to green
        }
      }));
    }
  }

}
