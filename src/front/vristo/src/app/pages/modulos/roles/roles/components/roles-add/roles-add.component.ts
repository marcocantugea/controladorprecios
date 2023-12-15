import { Component, EventEmitter, Input, Output } from '@angular/core';
import { FormBuilder, Validators } from '@angular/forms';


@Component({
  selector: 'app-roles-add',
  templateUrl: './roles-add.component.html',
  styleUrls: ['./roles-add.component.css']
})
export class RolesAddComponent {

  @Input() showForm:boolean=false;
  showErrorMessage:boolean=false;
  ErrorMessage="";

  @Output() hideForm:EventEmitter<boolean>= new EventEmitter();
  @Output() rolDataToSave:EventEmitter<any>= new EventEmitter();

  frmRol=this.fromBuilder.group({
    rol:['',[Validators.required,Validators.minLength(5)]]
  });

  constructor(private fromBuilder:FormBuilder){}

  CloseAddForm(){
    this.hideForm.emit(false);
    this.frmRol.reset();
  }

  SaveData(){
    this.showErrorMessage=false;
    if(!this.frmRol.valid){
      this.ErrorMessage="Rol invalido o Nombre del rol debe contener al menos 5 caracteres";
      this.showErrorMessage=true;
      return;
    }

    this.rolDataToSave.emit(this.frmRol.value);
    this.hideForm.emit(false);
    this.frmRol.reset();

  }

}
