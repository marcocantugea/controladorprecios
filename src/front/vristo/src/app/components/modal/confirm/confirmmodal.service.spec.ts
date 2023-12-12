import { TestBed } from '@angular/core/testing';

import { ConfirmModalService } from './confirmmodal.service';

describe('ConfirmmodalService', () => {
  let service: ConfirmModalService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ConfirmModalService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
