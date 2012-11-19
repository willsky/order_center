function strftime( timestamp ) {
    timestamp = timestamp * 1000;
    var date_obj = new Date(timestamp);
    return date_obj.getFullYear() + "-" + (date_obj.getMonth() + 1) + "-" + date_obj.getDate() +
        " " + date_obj.getHours() + ":" + date_obj.getMinutes();
}

function order_state (status) {
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


function getTransports(){
    /*var transports = new Array("EMS"，"顺风物流", "中通", "申通", "宅急送");*/
    /*console.log(transports);*/
}
