import { Component, EventEmitter, Input, Output } from '@angular/core';
import { FormBuilder,Validator, Validators } from '@angular/forms';

@Component({
  selector: 'app-usuario-add',
  templateUrl: './usuario-add.component.html',
  styleUrls: ['./usuario-add.component.css']
})
export class UsuarioAddComponent {

  
  frmUsuario=this.formBuilder.group({
    user:["",[Validators.required,Validators.minLength(5)]],
    email:["",[Validators.required,Validators.email]],
    password:["",[Validators.required,Validators.minLength(8)]]
  })
  showErrorMessage:boolean=false;
  ErrorMessage:string="";

  @Input() showForm:boolean=false;

  @Output() hideForm:EventEmitter<boolean>=new EventEmitter();

  @Output() userDataToSave:EventEmitter<any> = new EventEmitter();

  constructor(private formBuilder:FormBuilder){}

  CloseAddForm(){
    this.hideForm.emit(false);
    this.frmUsuario.reset();
  }

  SaveData(){
    this.showErrorMessage=false;
    console.log('saving data');
    if(!this.frmUsuario.valid){
        this.ErrorMessage="Informacion invalida, favor de revisar los datos ingresados";
        this.showErrorMessage=true;
        return;
    }
    this.userDataToSave.emit(this.frmUsuario);
    this.hideForm.emit(false);
    this.frmUsuario.reset();
  }


}
