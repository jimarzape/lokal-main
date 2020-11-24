<?php

function knumber($num) {

  if($num>1000) {

        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array('k', 'm', 'b', 't');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];

        return $x_display;
  }

  return null2zero($num);
}

function null2zero($value)
{
  if($value == null)
  {
    $value = 0;
  }
  return $value;
}

function discount($orignal, $sale_price)
{
  try
  {
    $percent = ($orignal - $sale_price) / $orignal;
    $disc = number_format(($percent * 100));
    return $disc;
  }
  catch(\Exception $e)
  {
    return 0;
  }
}

function discount_str($amount)
{
  try
  {
    if($amount != null)
    {
      return '₱ '.number_format($amount, 2);
    }
    
  }
  catch(\Exception $e)
  {
    return '';
  }
}

function order_number()
{
  return 'LKL-'.rand_num(2).time().rand_num();
}

function cancel_number()
{
  return 'LKL-CNL-'.rand_num(2).time().rand_num();
}

function seller_number()
{
  return 'SN-'.rand_num(2).time().rand_num();
}

function rand_char($count = 8)
{
  $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  return substr(str_shuffle($permitted_chars), 0, $count);
}

function rand_num($count = 5)
{
  $permitted_chars = '0123456789';
  return substr(str_shuffle($permitted_chars), 0,$count);
}

function date_now()
{
  return date('Y-m-d H:i:s');
}