import { Component, OnInit } from '@angular/core';
import { EtlService } from '../etl.service';
import { etlData } from '../models';

@Component({
  selector: 'app-datapresenter',
  templateUrl: './datapresenter.component.html',
  styleUrls: ['./datapresenter.component.css']
})
export class DatapresenterComponent implements OnInit {
  
  etlData: etlData;
  showOpinions: boolean = false;
  downloadCsvLink: string;

  constructor(private _etl: EtlService) {
   }

  ngOnInit() {
    this._etl.etlData.subscribe(res => this.etlData = res);
    this._etl.csvDownloadLink.subscribe(res => this.downloadCsvLink = res);
  }

  public decode(text : string) : string {
    return decodeURIComponent(text);
  }

  toggleOpinions(){
    this.showOpinions = !this.showOpinions;
  }
}
