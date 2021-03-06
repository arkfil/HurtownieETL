import { Component, OnInit, Injectable } from '@angular/core';
import { EtlService } from '../etl.service';
import { FormsModule } from '@angular/forms';
import { flowControl, etlData } from '../models';
import { BehaviorSubject } from 'rxjs/BehaviorSubject';
import { Observable } from 'rxjs/Observable';


@Component({
  selector: 'app-etl',
  templateUrl: './etl.component.html',
  styleUrls: ['./etl.component.css']
})

@Injectable()
export class EtlComponent implements OnInit {

  constructor(private _etlService: EtlService) { }
  public showData: boolean = false;
  
  private productId: string;
  private etlData: etlData;
  private errorMsg: string;

  private eFlowControl: flowControl;
  private tFlowControl: flowControl;
  private lFlowControl: flowControl;
  private etlFlowControl: flowControl;

  ngOnInit() {
    this._etlService.etlData.subscribe(res => this.etlData = res);

    this.eFlowControl = new flowControl("E", true, () => this.eRequest());
    this.tFlowControl = new flowControl("T", false, () => this.tRequest());
    this.lFlowControl = new flowControl("L", false, () => this.lRequest());
    this.etlFlowControl = new flowControl("ETL", true, () => this.etlRequest());
  }

  reset() : void{
    this.productId = null;
    this.showData = false;
    this._etlService.reset();

    this.eFlowControl.reset();
    this.tFlowControl.reset();
    this.lFlowControl.reset();
    this.etlFlowControl.reset();
  }

  eRequest(): void {
    this.tFlowControl.reset();
    this.lFlowControl.reset();
    this.etlFlowControl.reset();
    this.errorMsg = null;
    this.eFlowControl.fetching = true;

    this._etlService.setProductId(this.productId);

    this._etlService.eRequest().then(res => {
      this.eFlowControl.success();
      this.tFlowControl.allowed = true;
    }, rej => {
      this.errorMsg = "Wpisz prawidłowy kod produktu!";
      this.eFlowControl.fail();
    });
  }
  
  tRequest(): void {
    this.lFlowControl.reset();
    this.etlFlowControl.reset();
    
    this.tFlowControl.fetching = true;

    this._etlService.tRequest().then(res => {
      this.tFlowControl.success();
      this.lFlowControl.allowed = true;
    }, rej => {
      this.errorMsg = "Wpisz prawidłowy kod produktu!";
      this.tFlowControl.fail();
    });
  }

  lRequest(): void {
    this.etlFlowControl.reset();
    
    this.lFlowControl.fetching = true;

    this._etlService.lRequest().then(res => {
      this.lFlowControl.success();
      this.showData = true;
    }, rej => {
      this.lFlowControl.fail();
      this.errorMsg = "Wpisz prawidłowy kod produktu!";
    });

  }

  etlRequest(): void {

    this.eFlowControl.reset();
    this.tFlowControl.reset();
    this.lFlowControl.reset();
    this.etlFlowControl.reset();
    this.errorMsg = null;
    this.etlFlowControl.fetching = true;
    this._etlService.setProductId(this.productId);
    
    this._etlService.etlRequest().then(res => {
      this.etlFlowControl.success();
      this.showData = true;
    }, rej => {
      this.etlFlowControl.fail();
      this.errorMsg = "Wpisz prawidłowy kod produktu!";
    });
  }


}