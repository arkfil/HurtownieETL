import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs/BehaviorSubject';

@Injectable()
export class EtlService {
  
  private _model = {

  }
  
  private _etldata = new BehaviorSubject<any>(this._model);
  etlData = this._etldata.asObservable();

  constructor() { }
  
}
