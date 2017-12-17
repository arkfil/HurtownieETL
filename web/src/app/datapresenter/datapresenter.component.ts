import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { Router } from '@angular/router';
import {EtlService} from '../etl.service';

@Component({
  selector: 'app-datapresenter',
  templateUrl: './datapresenter.component.html',
  styleUrls: ['./datapresenter.component.css']
})
export class DatapresenterComponent implements OnInit {
  etldata: any;

  constructor(private route: ActivatedRoute, private router: Router, private _etl: EtlService) {
    this.route.params.subscribe(res => console.log(res.id));
   }

  ngOnInit() {
    this._etl.etlData.subscribe(res => this.etldata = res);
  }
sendMeHome(){
  this.router.navigate([''])
  }

}
