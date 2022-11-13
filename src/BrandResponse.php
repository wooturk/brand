<?php
namespace Tulparstudyo;
class BrandResponse{
	static public function success($message, $data=[]){
		return[
			'status'=>1,
			'message'=>$message,
			'data'=>$data
		];
	}
	static public function failure($message, $data=[]){
		return[
			'status'=>0,
			'message'=>$message,
			'data'=>$data
		];
	}
}
