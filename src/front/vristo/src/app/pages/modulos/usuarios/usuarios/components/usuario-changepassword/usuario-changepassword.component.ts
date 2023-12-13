import { Component, Inject } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';

@Component({
  selector: 'app-usuario-changepassword',
  templateUrl: './usuario-changepassword.component.html',
  styleUrls: ['./usuario-changepassword.component.css']
})
export class UsuarioChangepasswordComponent {

  showErrorMessage=false;
  errorMessage="";

  frmPassword=this.formBuilder.group({
    password:["",[Validators.required,Validators.minLength(8)]],
    passwordConfirm:['',[Validators.required,Validators.minLength(8)]]
  })

  constructor(@Inject(MAT_DIALOG_DATA) public data: any,private formBuilder:FormBuilder,public dialogRef: MatDialogRef<UsuarioChangepasswordComponent>,){}

  onNoClick(): void {
    this.dialogRef.close();
  }

  VerifyPassWords(){
    this.showErrorMessage=false;
    if(!this.frmPassword.controls.password.valid || !this.frmPassword.controls.passwordConfirm.valid){
      this.showErrorMessage=true;
      this.errorMessage="Favor de revisar contraseña, minimo 8 caracteres";
      return;
    }
    
    if(this.frmPassword.controls.password.value!=this.frmPassword.controls.passwordConfirm.value){
      this.showErrorMessage=true;
      this.errorMessage="Las contraseñas no coinciden";
      return;
    }


    this.dialogRef.close(this.frmPassword.value);
  }
}
