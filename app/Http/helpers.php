<?php

function action_query($action, $params) {
    return action($action) . "?" . http_build_query($params);
}

function route_query($route_name, $params) {
    return route($route_name) . "?" . http_build_query($params);
}