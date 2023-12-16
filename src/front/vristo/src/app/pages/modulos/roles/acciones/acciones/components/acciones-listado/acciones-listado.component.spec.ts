import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AccionesListadoComponent } from './acciones-listado.component';

describe('AccionesListadoComponent', () => {
  let component: AccionesListadoComponent;
  let fixture: ComponentFixture<AccionesListadoComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ AccionesListadoComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(AccionesListadoComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
