import { Component } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { ConfirmModalService } from 'src/app/components/modal/confirm/confirmmodal.service';
import { LoadingModalService } from 'src/app/components/modal/loading/loading/loading.service';
import { IUsuario } from 'src/app/services/admin/modulos/IUsuario';
import { UsuariosService } from 'src/app/services/admin/modulos/usuarios.service';
import { UsuarioChangepasswordComponent } from './components/usuario-changepassword/usuario-changepassword.component';

@Component({
  selector: 'app-usuarios',
  templateUrl: './usuarios.component.html',
  styleUrls: ['./usuarios.component.css']
})
export class UsuariosComponent {

  showAddUser:boolean=false;
  listUsuarios:IUsuario[]=[];

  constructor(private usuariosService:UsuariosService,private loadingModal:LoadingModalService,private confirmModal:ConfirmModalService,private dialog: MatDialog) {}
  
  ngOnInit(): void {
    this.LoadData();
    
  }

  showFormAddUser(){
    this.showAddUser=true
  }

  hideFormAddUser($event:any){
    this.showAddUser=$event;
  }

  LoadData(showLoading:boolean=true){
    if(showLoading)this.loadingModal.showLoading();
    this.getListaUsuarios().subscribe({
      next:(response)=>{
        if(!response.success){
          //todo error modal
          return;
        }
        
        this.listUsuarios=response.data;
      },
      error:(error)=>{
        //todo : error modal
      },
      complete:()=>{
        if(showLoading) {
          setTimeout(() => {
            this.loadingModal.closeLoading();  
          }, 800); 
        }
      }
    })
  }

  getListaUsuarios(){
    return this.usuariosService.getUsuariosSistema();
  }

  SaveNewUser($event:any){
    this.loadingModal.showLoading()
    this.usuariosService.AddUsuario($event.value as IUsuario).subscribe({
      next:(response)=>{
        if(!response.success){
          //todo:error modal
        }
        this.LoadData();
      },
      error:(error)=>{
        //todo: error modal
        console.log(error);
        return;
      },
      complete:()=>{
       
      }
    })

  }

  DeleteUsuario($event:string){
    this.loadingModal.showLoading()
    this.usuariosService.DeleteUsuario($event).subscribe({
      next:(response)=>{
        if(!response.success){
          //todo : show error modal  
        }
        this.LoadData();
      },
      error:(error)=>{
        //todo : show error modal
      },
      complete:()=>{}
    })
  }

  ActivarUsuario($event:string){
    this.loadingModal.showLoading();
    this.usuariosService.ActivarUsuario($event).subscribe({
      next:(response)=>{
        if(!response.success){
          //todo : show error modal  
        }
        this.LoadData();
      },
      error:(error)=>{
        //todo : show error modal
      },
    })
  }

  DesactivarUsuario($event:string){
    this.loadingModal.showLoading();
    this.usuariosService.DesactivarUsuario($event).subscribe({
      next:(response)=>{
        if(!response.success){
          //todo : show error modal  
        }
        this.LoadData();
      },
      error:(error)=>{
        //todo : show error modal
      },
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
            //todo: show error modal
            return;
          }
        },
        error:(error)=>{},
        complete:()=>{
          this.loadingModal.closeLoading();
        }
      })
    })
  }

}
