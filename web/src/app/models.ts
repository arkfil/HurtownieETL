export class eData {
    status?: string;
    object_type?: string;
    cached_rough_data_id?: number;
    element_id?: number;
    data?: data;
  };

class data {
    status?: string;
    description?: string;
  };

export class etlData {
    public status: string;
    public element_id: number;
    public object_type: string;
    public product_data: productData;
}

class productData {
    public brand: string;
    public model: string;
    public type: string;
    public opinions: Array<opinion>;
    public remarks: Array<string>;
}

class opinion {
    public author: string;
    public date: DateTimeFormat;
    public summary: string;
    
    public up_votes: number;
    public down_votes: number;
    public positive: number;
    public stars: number;
    public advantages: Array<string>;
    public disadvantages: Array<string>;
}
export class etlRequestStatus{
    public status: string;
    public object_type: string;
    public data: etlErrorData;
}

export class etlErrorData{
    public error_code: number;
    public description: string;
}

interface action {
    () : void;
}

export class flowControl {
    
        constructor(flowName: string, flowAllowed: boolean, requestAction : action){
            this.name = flowName;
            this._initialAllowed = flowAllowed;
            this.allowed = flowAllowed;
            this._requestAction = requestAction;
        };
    
        public name: string;
        public fetching: boolean = false;
        public allowed: boolean;
        public status: string;
        public error: string;

        private _initialAllowed: boolean;
        private _requestAction : action;

        request(){
            this._requestAction();
        }

        reset(){
            this.allowed = this._initialAllowed;
            this.status = null;
            this.fetching = false;
            this.error = null;
        }

    
        success(){
            this.fetching = false;
            this.status = "ok";
        }
    
        fail(){
            this.fetching = false;
            this.status = "fail";
        }
    
    }