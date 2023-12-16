import { Component } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { ConfirmModalService } from 'src/app/components/modal/confirm/confirmmodal.service';
import { LoadingModalService } from 'src/app/components/modal/loading/loading/loading.service';
import { IUsuario } from 'src/app/services/admin/modulos/usuarios/IUsuario';
import { UsuariosService } from 'src/app/services/admin/modulos/usuarios/usuarios.service';
import { UsuarioChangepasswordComponent } from './components/usuario-changepassword/usuario-changepassword.component';
import { ErrorModalService } from 'src/app/components/modal/error/error-modal.service';
import { UsuarioRolComponent } from './components/usuario-rol/usuario-rol.component';
import { IRol } from 'src/app/services/admin/modulos/roles/IRol';
import { RolService } from 'src/app/services/admin/modulos/roles/rol.service';
import { resolve } from 'path';
import { IRolUsuario } from 'src/app/services/admin/modulos/roles/IRolUsuario';
import { Observable, Observer, Subscriber, Subscription, forkJoin } from 'rxjs';

@Component({
  selector: 'app-usuarios',
  templateUrl: './usuarios.component.html',
  styleUrls: ['./usuarios.component.css']
})
export class UsuariosComponent {

  showAddUser:boolean=false;
  listUsuarios:IUsuario[]=[];
  listRoles:IRol[]=[];
  subscribers:Subscription[]=[];

  commonError=(error:any)=>{
    this.loadingModal.closeLoading();  
    this.errorModal.showErrorDialog("Error al procesar la peticion");
    console.log(error);
  };

  constructor(private usuariosService:UsuariosService,private loadingModal:LoadingModalService,private confirmModal:ConfirmModalService,private dialog: MatDialog, private errorModal:ErrorModalService, private rolesService:RolService) {}
  
  ngOnInit(): void {
    this.LoadData();
    
  }

  ngOnDestroy(): void {
    this.subscribers.forEach((subscription)=>{
      subscription.unsubscribe();
    })    
  }

  showFormAddUser(){
    this.showAddUser=true
  }

  hideFormAddUser($event:any){
    this.showAddUser=$event;
  }

  LoadData(showLoading:boolean=true){

    if(showLoading)this.loadingModal.showLoading();

    this.subscribers.push(forkJoin({
        listUsuarios:this.getListaUsuarios(),
        listRoles : this.rolesService.GetRoles()
      }
    ).subscribe((results)=>{
      if(!results.listUsuarios.success || !results.listRoles.success){
        this.loadingModal.closeLoading();  
        this.errorModal.showErrorDialog("Error al procesar la peticion");
        console.log(results.listUsuarios.message);
        console.log(results.listRoles.message);
        return;
      }

      this.listUsuarios=results.listUsuarios.data;
      this.listRoles=results.listRoles.data;
    },
    this.commonError,
    ()=>{
      if(showLoading) {
        this.loadingModal.closeLoading();  
      }
    }));
    
  }

  getListaUsuarios(){
    return this.usuariosService.getUsuariosSistema();
  }

  SaveNewUser($event:any){
    this.loadingModal.showLoading()
    this.usuariosService.AddUsuario($event.value as IUsuario).subscribe({
      next:(response)=>{
        if(!response.success){
          this.loadingModal.closeLoading();  
          this.errorModal.showErrorDialog("Error al procesar la peticion");
          console.log(response.message);
        }
        this.LoadData();
      },
      error:this.commonError,
      complete:()=>{
       
      }
    })

  }

  DeleteUsuario($event:string){
    this.loadingModal.showLoading()
    this.usuariosService.DeleteUsuario($event).subscribe({
      next:(response)=>{
        if(!response.success){
          this.loadingModal.closeLoading();  
          this.errorModal.showErrorDialog("Error al procesar la peticion");
          console.log(response.message);
        }
        this.LoadData();
      },
      error:this.commonError,
      complete:()=>{}
    })
  }

  ActivarUsuario($event:string){
    this.loadingModal.showLoading();
    this.usuariosService.ActivarUsuario($event).subscribe({
      next:(response)=>{
        if(!response.success){
          this.loadingModal.closeLoading();  
          this.errorModal.showErrorDialog("Error al procesar la peticion");
          console.log(response.message);
        }
        this.LoadData();
      },
      error:this.commonError,
    })
  }

  DesactivarUsuario($event:string){
    this.loadingModal.showLoading();
    this.usuariosService.DesactivarUsuario($event).subscribe({
      next:(response)=>{
        if(!response.success){
          this.loadingModal.closeLoading();  
          this.errorModal.showErrorDialog("Error al procesar la peticion");
          console.log(response.message);
        }
        this.LoadData();
      },
      error:this.commonError,
    })
  }

  CambiarPassword($event:any){
    const modal=this.dialog.open(UsuarioChangepasswordComponent,{
      width:"350px"
    });

    modal.afterClosed().subscribe((result)=>{
      if(!result)return;
      this.loadingModal.showLoading();
      this.usuariosService.ActualizarPassword($event.publicId,result.password).subscribe({
        next:(response)=>{
          if(!response.success){
            this.loadingModal.closeLoading();  
            this.errorModal.showErrorDialog("Error al procesar la peticion");
            console.log(response.message);
            return;
          }
          
        },
        error:this.commonError,
        complete:()=>{
          this.loadingModal.closeLoading();
        }
      })
    })
  }

  AsignarRol($event:any){
    let rolUsuario:IRolUsuario;
    this.loadingModal.showLoading();
    this.rolesService.GetRolDeUsuario($event.publicId).subscribe({
      next:(response)=>{
        if(!response.success){
          this.loadingModal.closeLoading();  
          this.errorModal.showErrorDialog("Error al procesar la peticion");
          console.log(response.message);
          return;
        }

        if(response.data){
          rolUsuario=response.data;
        }else{
          rolUsuario={
            usuarioPid:"",
            rolPid:"-1"
          };
        }
        
      },
      error:this.commonError,
      complete:()=>{
        this.loadingModal.closeLoading();
        const modal=this.dialog.open(UsuarioRolComponent,{
          width:"350px",
          disableClose: true
        })
        let instance = modal.componentInstance;
        instance.roles=this.listRoles;
        instance.userRolSelected=rolUsuario;
        
        modal.afterClosed().subscribe((result)=>{
          
          let rolusuario:IRolUsuario={
            usuarioPid:$event.publicId,
            rolPid:result.rol
          }
    
          this.loadingModal.showLoading()
          this.rolesService.AddRolUsuario(rolusuario).subscribe({
            next:(response)=>{
              if(!response.success){
                this.loadingModal.closeLoading();  
                this.errorModal.showErrorDialog("Error al procesar la peticion");
                console.log(response.message);
                return;
              }
            },
            error:this.commonError,
            complete:()=>{
              this.loadingModal.closeLoading();
            }
          })
          
        })

      }
    })
  }

}
