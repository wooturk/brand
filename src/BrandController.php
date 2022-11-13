<?php

namespace Tulparstudyo;
use App\Http\Controllers\Controller;
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
		$fields = $request->validate([
			'name'       => 'required|string|max:255',
			'code'       => 'required|string|max:32',
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
			return BrandResponse::success( "Marka Bulundu", $brand);

		}
		return BrandResponse::failure("Marka Oluşturulamadı");
	}
	function put(Request $request, $id){
		$fields = $request->validate([
			'name'       => 'required|string|max:255',
			'code'       => 'required|string|max:32',
			'rate'       => 'required|integer',
			'sort_order' => 'required|integer',
			'state'      => 'required|boolean'
		]);
		$brand = Brand::where('id', $id)->update($fields);

		if($brand){
			$description = [
				'brand_id'=>	$brand->id,
				'name'=>	$request->get('name'),
				'description'=>	$request->get('description'),
			];
			Brand::where('brand_id', $id)->update($description);
			return BrandResponse::success( "Marka Güncellendi", $brand);

		}
		return BrandResponse::failure("Marka Güncellenemedi");

	}
	function delete(Request $request, $id){

	}
}
