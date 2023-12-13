import { Component, Inject, Input } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { IRol } from 'src/app/services/admin/modulos/roles/IRol';
import { IRolUsuario } from 'src/app/services/admin/modulos/roles/IRolUsuario';


@Component({
  selector: 'app-usuario-rol',
  templateUrl: './usuario-rol.component.html',
  styleUrls: ['./usuario-rol.component.css']
})
export class UsuarioRolComponent {

  @Input() roles:IRol[]=[];
  @Input() userRolSelected:IRolUsuario={usuarioPid:"",rolPid:""};
  showErrorMessage=false;
  errorMessage="";

  frmRolSelecton=this.formBuilder.group({
    rol:["-1"]
  })

  constructor(@Inject(MAT_DIALOG_DATA) public data: IRolUsuario,public dialogRef: MatDialogRef<UsuarioRolComponent>,private formBuilder:FormBuilder){}

  onCancelClick(): void {
    this.dialogRef.close();
  }

  onSelectClick():void{
    this.showErrorMessage=false;
    if(this.frmRolSelecton.controls.rol.value=="-1"){
      this.showErrorMessage=true;
      this.errorMessage="Seleccione una opción valida";
      return;
    }
    this.dialogRef.close(this.frmRolSelecton.value);
  }

  

}
