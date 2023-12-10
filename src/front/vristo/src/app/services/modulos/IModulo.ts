import { IMenu } from "../menus/IMenu";

export interface IModulo{
    pid:string,
    nombre:string,
    display:string,
    activo:boolean,
    menus?:IMenu[]
}