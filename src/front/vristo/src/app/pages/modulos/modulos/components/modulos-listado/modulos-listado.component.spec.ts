import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ModulosListadoComponent } from './modulos-listado.component';

describe('ModulosListadoComponent', () => {
  let component: ModulosListadoComponent;
  let fixture: ComponentFixture<ModulosListadoComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ModulosListadoComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ModulosListadoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
