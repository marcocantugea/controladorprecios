import { Component, EventEmitter, Input, Output } from '@angular/core';
import { ConfirmModalService } from 'src/app/components/modal/confirm/confirmmodal.service';
import { LoadingModalService } from 'src/app/components/modal/loading/loading/loading.service';
import { IUsuario } from 'src/app/services/admin/modulos/usuarios/IUsuario';
import { UsuariosService } from 'src/app/services/admin/modulos/usuarios/usuarios.service';

@Component({
  selector: 'app-usuario-listado',
  templateUrl: './usuario-listado.component.html',
  styleUrls: ['./usuario-listado.component.css']
})
export class UsuarioListadoComponent {

  @Input() listUsuarios:IUsuario[]=[];
  @Output() deleteUser:EventEmitter<string>=new EventEmitter();
  @Output() activarUser:EventEmitter<string>=new EventEmitter();
  @Output() desActivarUser:EventEmitter<string>=new EventEmitter();
  @Output() changePassword:EventEmitter<IUsuario>=new EventEmitter();
  @Output() asignarRol:EventEmitter<IUsuario>=new EventEmitter();

  constructor(private confirmModel:ConfirmModalService) {}

  ngOnInit(): void {}

  EliminarUsuario(usuario:IUsuario){
    const modal=this.confirmModel.showConfirm("Desea eliminar el usuario?");
    modal.afterClosed().subscribe((response)=>{
      if(response!==true) return;
      
      this.deleteUser.emit(usuario.publicId);
    })
  }

  ActivarUsuario(usuario:IUsuario){
    const modal=this.confirmModel.showConfirm("Desea activar este usuario?");
    modal.afterClosed().subscribe((response)=>{
      if(response!==true) return;
      this.activarUser.emit(usuario.publicId);
    })
  }

  DesactivarUsuario(usuario:IUsuario){
    const modal=this.confirmModel.showConfirm("Desea activar este usuario?");
    modal.afterClosed().subscribe((response)=>{
      if(response!==true) return;
      this.desActivarUser.emit(usuario.publicId);
    })
  }

  CambiarPassword(usuario:IUsuario){
    this.changePassword.emit(usuario);
  }

  AsignarRol(usuario:IUsuario){
    this.asignarRol.emit(usuario);
  }
}
