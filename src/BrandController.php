<?php

namespace Wooturk;
use App\Http\Controllers\Controller;
use Google\Exception;
use Illuminate\Http\Request;


class BrandController extends Controller
{
	function index(Request $request){
		return Response::success("Lütfen Giriş Yapınız");
	}
	function list(Request $request){
		if($rows = get_brands( $request->all() )){
			return Response::success("Marka Bilgileri", $rows);
		}
		return Response::failure("Marka Bulunamdı");
	}
	function get(Request $request, $id){
		if($brand = get_brand($id)){
			return Response::success("Marka Bilgileri", $brand);
		}
		return Response::failure("Marka Bulunamdı");
	}
	function post(Request $request) {
		$exception = '';
		try {
			$fields = $request->validate([
				'name'       => 'required|string|max:255',
				'code'       => 'required|string|max:32|unique:brands',
				'slug'       => 'required|string',
				'sort_order' => 'required|integer',
				'status'      => 'required|boolean'
			]);
			$brand = create_brand($fields);
			if($brand){
				return Response::success("Marka Oluşturuldu", $brand);
			}
			return Response::failure("Marka Oluşturulamadı");
		} catch(\Illuminate\Database\QueryException $ex){
			$exception = $ex->getMessage();
		} catch (Exception $ex){
			$exception = $ex->getMessage();
		}
		return Response::exception( $exception);
	}
	function put(Request $request, $id){
		$exception = '';
		try {
			$fields = $request->validate([
				'name'       => 'required|string|max:255',
				'code'       => 'required|string|max:32|unique:brands',
				'rate'       => 'required|integer',
				'sort_order' => 'required|integer',
				'status'      => 'required|boolean'
			]);
			$brand = update_brand($id, $fields);
			if($brand){
				return Response::success("Marka Güncellendi", $brand);
			}
			return Response::failure("Marka Güncellenemedi");
		} catch(\Illuminate\Database\QueryException $ex){
			$exception = $ex->getMessage();
		} catch (Exception $ex){
			$exception = $ex->getMessage();
		}
		return Response::exception( '$exception');
	}
	function delete(Request $request, $id){
		$exception = '';
		try {
			$brand = Brand::where('id', $id)->get()->first();
			if($brand){
				Brand::destroy($id);
				BrandDescription::where('brand_id', $id)->delete();
				return Response::success( "Marka silindi", $brand);
			} else {
				return Response::failure("Marka Bulunamadı");
			}
			return BrandResponse::failure("Marka Silinemedi");
		} catch(\Illuminate\Database\QueryException $ex){
			$exception = $ex->getMessage();
		} catch (Exception $ex){
			$exception = $ex->getMessage();
		}
		return Response::exception( $exception );
	}

	// MODELS
	function models(Request $request, $id){
		if($brand = get_brand($id)){
			if($rows = get_brand_models( $id )){
				return Response::success($brand['name']." Modelleri", $rows);
			}
			return Response::failure($brand['name']." Modelleri Bulunamdı");
		} else{
			return Response::failure("Marka Bulunamdı");
		}
	}
	function model_post(Request $request) {
		$exception = '';
		try {
			$fields = $request->validate([
				'name'       => 'required|string|max:255',
				'code'       => 'required|string|max:32|unique:brands',
				'slug'       => 'required|string',
				'sort_order' => 'required|integer',
				'status'      => 'required|boolean',
				'brand_id_code'      => 'string|max:32',
				'parent_id_code'      => 'string|max:32'
			]);
			$brand = create_model($fields);
			if($brand){
				return Response::success("Model Oluşturuldu", $brand);
			}
			return Response::failure("Model Oluşturulamadı");
		} catch(\Illuminate\Database\QueryException $ex){
			$exception = $ex->getMessage();
		} catch (Exception $ex){
			$exception = $ex->getMessage();
		}
		return Response::exception( $exception);
	}
}
