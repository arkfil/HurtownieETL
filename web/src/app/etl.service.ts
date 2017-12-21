import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs/BehaviorSubject';
import { HttpClient } from '@angular/common/http';

@Injectable()
export class EtlService {
  
  private _model = {"status":"BBB"

  }
  
  private _etldata = new BehaviorSubject<object>(this._model);
 public etlData = this._etldata.asObservable();

  constructor(private _http: HttpClient) { }

  getData(id)
  {
    let response;
    let url = 'http://localhost/api/ETL/' + id;
    this._http.get(url).subscribe(data => {
      this._etldata.next(data);
    });
    
  }
  
}
