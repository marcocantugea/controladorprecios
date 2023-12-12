import { Injectable } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { ConfirmComponent } from './confirm.component';

@Injectable({
  providedIn: 'root'
})
export class ConfirmModalService {

  modal:MatDialog;
  proceed:boolean=false;

  constructor(private dialog:MatDialog) { 
    this.modal=dialog;
  }

  showConfirm(message:string){
    return this.modal.open(ConfirmComponent,{
      width:"350px",
      height:"160px",
      data:message
    });

  }


}
