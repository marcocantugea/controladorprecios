import { Component } from '@angular/core';
import { Subscription, forkJoin } from 'rxjs';
import { ConfirmModalService } from 'src/app/components/modal/confirm/confirmmodal.service';
import { ErrorModalService } from 'src/app/components/modal/error/error-modal.service';
import { LoadingModalService } from 'src/app/components/modal/loading/loading/loading.service';
import { IRol } from 'src/app/services/admin/modulos/roles/IRol';
import { RolService } from 'src/app/services/admin/modulos/roles/rol.service';

@Component({
  selector: 'app-roles',
  templateUrl: './roles.component.html',
  styleUrls: ['./roles.component.css']
})
export class RolesComponent {

  listRols:IRol[]=[];
  showAddForm:boolean=false;
  subcribers:Subscription[]=[];
  ErrorCommon=(error:any)=>{
    this.loadingModal.closeLoading();  
    this.errorModal.showErrorDialog("Error al procesar la peticion "+ error.error.message);
    console.log(error);
  }


  constructor(private rolService:RolService,private loadingModal:LoadingModalService,private confirmModal:ConfirmModalService,private errorModal:ErrorModalService){}

  ngOnInit(): void {
    this.loadData();
  }

  ngOnDestroy(): void {
    this.subcribers.forEach((subscription)=>{
      subscription.unsubscribe();
    });
  }

  displayAddForm(){
    this.showAddForm=true;
  }

  hideForm($event:boolean){
    this.showAddForm=$event
  }

  loadData(){
    this.loadingModal.showLoading();
    this.subcribers.push(this.rolService.GetRoles().subscribe({
      next:(response)=>{
        if(!response.success){
          this.showErrorNoSuccess(response.message);
        }
        this.listRols=response.data;
      },
      error:this.ErrorCommon,
      complete:()=>{
        this.loadingModal.closeLoading();
      }
    }))
  }

  showErrorNoSuccess(message:string){
    this.loadingModal.closeLoading();  
    this.errorModal.showErrorDialog("Error al procesar la peticion");
    console.log(message);
  }

  SaveNewRol($event:any){
    this.loadingModal.showLoading();
    
    let request:IRol={
      rol:$event.rol,
      activo:true
    }

    this.subcribers.push(this.rolService.AddRol(request).subscribe({
      next:(response)=>{},
      error:this.ErrorCommon,
      complete:()=>{
        this.loadData();
      }
    }))
  }

  DeleteRol($event:string){
    this.loadingModal.showLoading();
    this.subcribers.push(this.rolService.DeleteRol($event).subscribe(
      {
        next:(response)=>{
          if(!response.success) this.showErrorNoSuccess(response.message);
        },
        error:this.ErrorCommon,
        complete:()=>{
          this.loadData();
        }
      }
    ));
  }
}
