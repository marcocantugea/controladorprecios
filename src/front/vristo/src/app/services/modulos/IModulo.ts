import { IMenu } from "../menus/IMenu";

export interface IModulo{
    publicId:string,
    nombre:string,
    display:string,
    activo:boolean,
    menus?:IMenu[]
}