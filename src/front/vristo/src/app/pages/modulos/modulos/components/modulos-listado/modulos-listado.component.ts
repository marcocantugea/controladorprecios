import { Component, EventEmitter, Input, Output } from '@angular/core';
import { IModulo } from 'src/app/services/modulos/IModulo';
import { IRolModulo } from 'src/app/services/modulos/IRolModulo';

@Component({
  selector: 'app-modulos-listado',
  templateUrl: './modulos-listado.component.html',
  styleUrls: ['./modulos-listado.component.css']
})
export class ModulosListadoComponent {

  @Input() listaModulos:IModulo[]=[];
  @Input() checkedModulos:IRolModulo[]=[];
  @Output() actionSelected:EventEmitter<any>= new EventEmitter();

  checkValue(modulo:IModulo,event: any){

    this.actionSelected.emit({
      checked:event.currentTarget.checked,
      modulo:modulo
    })
    
  }

  isChecked(pid:string):boolean{
    return this.checkedModulos.filter((item)=>item.moduloPid==pid).length>0;
  }

}
