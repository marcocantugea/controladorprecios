import { Injectable } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { LoadingComponent } from './loading.component';

@Injectable({
  providedIn: 'root'
})
export class LoadingModalService {

  modal:MatDialog;

  constructor(private dialog:MatDialog) { 
    this.modal=dialog;
  }

  showLoading(){
    this.modal.open(LoadingComponent,{
              height: '200px',
              width: '200px',
              disableClose: true
          });
  }

  closeLoading(){
    this.modal.closeAll();
  }
}
