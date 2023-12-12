import { TestBed } from '@angular/core/testing';

import { ConfirmmodalService } from './confirmmodal.service';

describe('ConfirmmodalService', () => {
  let service: ConfirmmodalService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ConfirmmodalService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
