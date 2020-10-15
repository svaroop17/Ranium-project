<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NeoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return view('main');
    }

    public function getData(Request $request) {
          $data =  json_decode($request->data);

          $ast_speed_arr = [];
          foreach ($data as $key => $value) {
              foreach ($value as $key => $value) {
                $ast_speed_arr_key = $key;
                  foreach ($value as $key => $value) {
                      if($key == 'id') {
                        $ast_speed_arr[$ast_speed_arr_key]['id'] = $value;
                      }
                      if($key == 'close_approach_data') {
                          $ast_speed_arr[$ast_speed_arr_key]['relative_velocity'] =  $value[0]->relative_velocity->kilometers_per_hour;
                      }
                  }
              }
          }

          $ast_dist_arr = [];
          foreach ($data as $key => $value) {
              foreach ($value as $key => $value) {
                $ast_dist_arr_key = $key;
                  foreach ($value as $key => $value) {
                      if($key == 'id') {
                        $ast_dist_arr[$ast_dist_arr_key]['id'] = $value;
                      }
                      if($key == 'close_approach_data') {
                          $ast_dist_arr[$ast_dist_arr_key]['miss_distance'] =  $value[0]->miss_distance->kilometers;
                      }
                  }
              }
          }

          $max_speed = 0;
          $max_speed_arr = [];
          foreach($ast_speed_arr as $k => $v )
          {
              if($v['relative_velocity'] > $max_speed) {
                    $max_speed = $v['relative_velocity'];
                    $max_speed_arr = $v;
              }
          }

          $max_dist = 0;
          foreach($ast_dist_arr as $k => $v )
          {
              if($v['miss_distance'] > $max_dist) {
                    $max_dist = $v['miss_distance'];
              }
          }

          $min_dist = $max_dist;
          $min_dist_arr = [];
          foreach($ast_dist_arr as $k => $v )
          {
              if($v['miss_distance'] < $min_dist) {
                    $min_dist = $v['miss_distance'];
                    $min_dist_arr = $v;
              }
          }

          $date_arr = [];
          $count_arr = [];
          foreach ($data as $key => $value) {
              $date_arr[]  = $key;
              $count_arr[] =array('t'=> $key,'y'=>count($value));
          }

        //    print_r($max_speed_arr);
        //    print_r($min_dist_arr);
           $output_data = [];
           array_push($output_data,$max_speed_arr);
           array_push($output_data,$min_dist_arr);
           array_push($output_data,$date_arr);
           array_push($output_data,$count_arr);
           echo json_encode($output_data);
        //   print_r($ast_speed_arr);
        //   print_r($ast_dist_arr);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
