import { Component, Input, Output } from '@angular/core';
import { IAccion } from 'src/app/services/admin/modulos/acciones/IAccion';
import { EventEmitter } from '@angular/core';
import { IRolAccion } from 'src/app/services/admin/modulos/acciones/IRolAccion';

@Component({
  selector: 'app-acciones-listado',
  templateUrl: './acciones-listado.component.html',
  styleUrls: ['./acciones-listado.component.css']
})
export class AccionesListadoComponent {

  @Input() listaAcciones:IAccion[]=[];
  @Input() checkedAcciones:IRolAccion[]=[];
  @Output() actionSelected:EventEmitter<any>= new EventEmitter();

  checkValue(accion:IAccion,event: any){

    this.actionSelected.emit({
      checked:event.currentTarget.checked,
      accion:accion
    })
    
  }

  isChecked(pid:string):boolean{
    return this.checkedAcciones.filter((item)=>item.accionPid==pid).length>0;
  }

}
