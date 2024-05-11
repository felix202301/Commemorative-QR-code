<?php
return [
    200 => 'success',
    400 => 'fail',
    402 => 'The key error or the request timeout',
    410 => 'The data does not exist',
    //3000-3100 用户相关
    3000 => 'token should be non-null',
    3001 => 'anthorization failed',
    3002 => 'Token validation failed',
    3003 => 'Please login first',
    3004 => 'Account is locked',
    3005 => 'Account has been cancelled',
    //3200-3300
    3200 => 'ID should be non-null',
    3201 => 'Content should be non-null',
    //4000-4100订单相关
    4000 => 'The order number is incorrect',
    4001 => 'order validation failed',
    4002 => 'The order has been returned',
    4003 => 'Please confirm your order status',
    4004 => '订单未消耗',
];
