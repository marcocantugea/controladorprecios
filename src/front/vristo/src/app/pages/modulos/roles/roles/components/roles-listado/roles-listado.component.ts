import { Component, EventEmitter, Input, Output } from '@angular/core';
import { ConfirmModalService } from 'src/app/components/modal/confirm/confirmmodal.service';
import { IRol } from 'src/app/services/admin/modulos/roles/IRol';

@Component({
  selector: 'app-roles-listado',
  templateUrl: './roles-listado.component.html',
  styleUrls: ['./roles-listado.component.css']
})
export class RolesListadoComponent {

  @Input() RolesList:IRol[]=[];
  @Output() deleteRol:EventEmitter<string>=new EventEmitter();

  constructor(private confirmModal:ConfirmModalService){}

  DeleteRol(rol:IRol){
    const modal= this.confirmModal.showConfirm("Dese elminar el Rol de usuario?");
    modal.afterClosed().subscribe((response)=>{
      if(response!==true) return;
      
      this.deleteRol.emit(rol.publicId);
    })
  }

}
