import { Injectable } from '@angular/core';
import { BehaviorSubject } from 'rxjs/BehaviorSubject';
import { HttpClient } from '@angular/common/http';
import { etlData, flowControl, eData } from './models';
import { promise } from 'protractor';

@Injectable()
export class EtlService {

  private _apiUrl: string = "http://localhost:1995/api";

  private _productId: string;
  private _eData: eData;

  private _etlData = new BehaviorSubject<etlData>(null);
  public etlData = this._etlData.asObservable();

  constructor(private _http: HttpClient) { }

  setProductId(productId: string) {
    this.reset();
    this._productId = productId;
  }

  reset() {
    this._productId = null;
    this._eData = null;
    this._etlData.next(null);
  }

  eRequest(): Promise<any> {
    let promise = new Promise((resolve, reject) => {

      let url = this._apiUrl + '/E/' + this._productId;

      this._http.get<eData>(url).toPromise().then(
        res => {
          if(res == null){
            reject();
          }
          this._eData = res;
          console.log('EtlService: eRequest: data extracted, cached_rough_data_id: ' + res.cached_rough_data_id)
          resolve();
        },
        error => {
          console.log('EtlService: eRequest error')
          reject();
        }
      );
    })

    return promise;
  };

  tRequest(): Promise<any> {
    let promise = new Promise((resolve, reject) => {

      let url = this._apiUrl + '/T/' + this._productId + '/' + this._eData.cached_rough_data_id;

      this._http.get<etlData>(url).toPromise().then(
        res => {
          if(res == null){
            reject();
          };
          this._etlData.next(res);
          console.log('EtlService: tRequest: data transformed and downloaded into etlService, element_id: ' + res.element_id)
          resolve();
        },
        error => {
          console.log('EtlService: tRequest error')
          reject();
        }
      );
    })
    return promise;
  };

  lRequest(): Promise<any> {
    let promise = new Promise((resolve, reject) => {

      let url = this._apiUrl + '/L/' + this._productId;

      this._http.put<etlData>(url, this._etlData.value).toPromise().then(
        res => {
          if(res == null){
            reject();
          };

          this._etlData.next(res);
          console.log('EtlService: lRequest: data loaded into DB')
          resolve();
        },
        error => {
          console.log(error);
          console.log('EtlService: lRequest error')
          reject();
        }
      );
    })
    return promise;
  };

  etlRequest(): Promise<any> {
    let promise = new Promise((resolve, reject) => {

      let url = this._apiUrl + '/ETL/' + this._productId;

      this._http.get<etlData>(url).toPromise().then(
        res => {
          if(res == null){
            reject();
          };

          this._etlData.next(res);
          console.log('EtlService: etlRequest: data extracted, transformed and loaded into DB')
          resolve();
        },
        error => {
          console.log('EtlService: etlRequest error')
          reject();
        }
      );
    })
    return promise;
  };
}