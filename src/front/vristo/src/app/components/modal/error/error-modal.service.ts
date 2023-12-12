import { Injectable } from '@angular/core';
import { MatDialog } from '@angular/material/dialog';
import { ErrorComponent } from './error.component';

@Injectable({
  providedIn: 'root'
})
export class ErrorModalService {

  constructor(private dialog:MatDialog) { }

  showErrorDialog(message:string){
    this.dialog.open(ErrorComponent,{
      width:"400px",
      height:"230px",
      data:message
    })
  }

  
}
