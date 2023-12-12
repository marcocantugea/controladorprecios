import { ComponentFixture, TestBed } from '@angular/core/testing';

import { UsuarioChangepasswordComponent } from './usuario-changepassword.component';

describe('UsuarioChangepasswordComponent', () => {
  let component: UsuarioChangepasswordComponent;
  let fixture: ComponentFixture<UsuarioChangepasswordComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ UsuarioChangepasswordComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(UsuarioChangepasswordComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
