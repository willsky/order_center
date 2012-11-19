function strftime( timestamp ) {
    timestamp = timestamp * 1000;
    var date_obj = new Date(timestamp);
    return date_obj.getFullYear() + "-" + (date_obj.getMonth() + 1) + "-" + date_obj.getDate() +
        " " + date_obj.getHours() + ":" + date_obj.getMinutes();
}

function order_state (status) {
    status = parseInt(status);
    _str_state = '未处理';

    do {
        switch (status) {
            case 0:
                _str_state = '未处理';
                break;
            case 1:
                _str_state = '已发货';
                break;
            case 2:
                _str_state = '已签收';
                break;
            case 3:
                _str_state = '退货中';
                break;
            case 4:
                _str_state = '完成退货';
                break;
            case 5:
                _str_state = '交易完成';
                break;
            case 10:
                _str_state = '作废';
                break;
        }

    } while(0);
    
    return _str_state;
}

function getOrderState()
{
    var orders = [{state:0, text:'未处理'},
                  {state:1, text:'已发货'},
                  {state:2, text:'已签收'}, 
                  {state:3, text:'退货中'},
                  {state:4, text:'完成退货'},
                  {state:5, text:'交易完成'},
                  {state:6, text:'作废'}];
    return orders;
}


function pay_state(state) {
    var _state_str = '未付款';

    do {
        switch(state) {
            case 0:
                _state_str = '未付款';
                break;
            case 1:
                _state_str = '货到付款';
                break;
            case 2:
                _state_str = '支付宝';
                break;
        }
    } while(0);
    
    return _state_str;
}

function transport(t_id) {
    var transports = getTransports();
    return transports[t_id];
}

function getTransports(){
    var transports = new Array('未发货', "EMS", "顺风物流", "中通", "申通", "宅急送",'韵达快递');
    return transports;
}

function getTransportList(){
    var transports= [{order:0, text:'未发货'},
                  {ts_id:1, text:'EMS'},
                  {ts_id:2, text:'顺风物流'}, 
                  {ts_id:3, text:'中通'},
                  {ts_id:4, text:'申通'},
                  {ts_id:5, text:'宅急送'},
                  {ts_id:6, text:'韵达快递'}];
    return transports;
}
