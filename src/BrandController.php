<?php

namespace Tulparstudyo;
use App\Http\Controllers\Controller;
use Google\Exception;
use Illuminate\Http\Request;
use Tulparite\Brand;
use Tulparite\BrandDescription;

class BrandController extends Controller
{
    //
	function index(Request $request){
		return BrandResponse::index(1, "Lütfen Giriş Yapınız");
	}
	function get(Request $request, $id){
		$brand = Brand::find($id);
		if($brand){
			return BrandResponse::success( "Marka Bulundu", $brand);
		} else{
			return BrandResponse::failure("Marka Bulunamadı");
		}
	}
	function post(Request $request) {
		$exception = '';
		try {
			$fields = $request->validate([
				'name'       => 'required|string|max:255',
				'code'       => 'required|string|max:32|unique:brands',
				'rate'       => 'required|integer',
				'sort_order' => 'required|integer',
				'state'      => 'required|boolean'
			]);
			$brand = Brand::create($fields);
			if($brand){
				$description = [
					'brand_id'=>	$brand->id,
					'name'=>	$request->get('name'),
					'description'=>	$request->get('description'),
				];
				BrandDescription::insert($description);
				return BrandResponse::success( "Marka Oluşturuldu", $brand);

			}
			return BrandResponse::failure("Marka Oluşturulamadı");
		} catch(\Illuminate\Database\QueryException $ex){
			$exception = $ex->getMessage();
		} catch (Exception $ex){
			$exception = $ex->getMessage();
		}
		return BrandResponse::exception( '$exception');
	}
	function put(Request $request, $id){
		$exception = '';
		try {
			$fields = $request->validate([
				'name'       => 'required|string|max:255',
				'code'       => 'required|string|max:32|unique:brands',
				'rate'       => 'required|integer',
				'sort_order' => 'required|integer',
				'state'      => 'required|boolean'
			]);
			$brand = Brand::where('id', $id)->update($fields);
			if($brand){
				$description = [
					'brand_id'=>	$id,
					'name'=>	$request->get('name'),
					'description'=>	$request->get('description'),
				];
				BrandDescription::where('brand_id', $id)->update($description);
				return BrandResponse::success( "Marka Güncellendi", $brand);

			}
			return BrandResponse::failure("Marka Güncellenemedi");
		} catch(\Illuminate\Database\QueryException $ex){
			$exception = $ex->getMessage();
		} catch (Exception $ex){
			$exception = $ex->getMessage();
		}
		return BrandResponse::exception( '$exception');
	}
	function delete(Request $request, $id){
		$exception = '';
		try {
			$brand = Brand::where('id', $id)->get()->first();
			if($brand){
				Brand::destroy($id);
				BrandDescription::where('brand_id', $id)->delete();
				return BrandResponse::success( "Marka silindi", $brand);
			} else {
				return BrandResponse::failure("Marka Bulunamadı");
			}
			return BrandResponse::failure("Marka Silinemedi");
		} catch(\Illuminate\Database\QueryException $ex){
			$exception = $ex->getMessage();
		} catch (Exception $ex){
			$exception = $ex->getMessage();
		}
		return BrandResponse::exception( '$exception');

	}
}
