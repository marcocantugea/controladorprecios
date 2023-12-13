import { Injectable } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { LoadingComponent } from './loading.component';

@Injectable({
  providedIn: 'root'
})
export class LoadingModalService {

  modal:MatDialog;
  isOpen:boolean=false;

  constructor(private dialog:MatDialog) { 
    this.modal=dialog;
  }

  showLoading(){
    if(this.isOpen) return;
    this.modal.open(LoadingComponent,{
              height: '200px',
              width: '200px',
              disableClose: true
          });
    this.isOpen=true;
  }

  closeLoading(){
    this.modal.closeAll();
    this.isOpen=false;
  }
}
