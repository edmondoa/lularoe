<?php
/*
SET FOREIGN_KEY_CHECKS=0;
TRUNCATE orders; 
TRUNCATE orderlines; 
SET FOREIGN_KEY_CHECKS=1;
*/
// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class OrdersTableSeeder extends DatabaseSeeder 
{

	public function run()
	{
		$faker = $this->getFaker();
		DB::connection()->disableQueryLog();
		Eloquent::unguard();
		$order_date = date('Y-m-d',strtotime('2 months ago'));
		$reps = User::all();

		foreach($reps as $rep)
		{
			$quantity = 0;
			$order_qty = $faker->numberBetween($min = 75, $max = 500);
			$order_total = 0;
			$points_total = 0;
			//if(mt_rand (1 , 100 ) <= 85) continue;

			//echo"<pre>"; print_r($plan->toArray()); echo"</pre>";
			//continue;
			while($quantity < $order_qty)
			{
				$order = new Order();
				$order_total = 0;
				$points_total = 0;
				$lines = [];
				$order_lines = $faker->numberBetween($min = 1, $max = 5);
				for($i = 1; $i <= $order_lines; $i++) {
					$line_qty = $faker->numberBetween($min = 1, $max = 3);
					$product = Product::orderByRaw("RAND()")->first();
					$order_total += $product->price;
					$points_total += $product->points_value;
					$lines[] = Orderline::create([
						'product_id'=> $product->id,
						'name'=> $product->name,
						'price_each'=>$product->price,
						'price_ext'=>$product->price*$line_qty,
						'points_each'=>$product->price,
						'points_ext'=>$product->price*$line_qty,
						'qty'=>$line_qty,
						'created_at'=> $order_date,
						'updated_at'=> $order_date
					]);
					$quantity += $line_qty;
				}
				if(count($lines) > 0)
				{
					$order->total_price = $order_total;
					$order->total_points = $points_total;
					$order->created_at = $order_date;
					$order->updated_at = $order_date;
					$order->save();
					$order->user()->associate($rep);
					$order->lines()->saveMany($lines);
					$order->save();
				}

			}
		}

		$order_date = date('Y-m-d',strtotime('last month'));
		//$reps = User::all();

		foreach($reps as $rep)
		{
			$quantity = 0;
			$order_qty = $faker->numberBetween($min = 75, $max = 500);
			while($quantity < $order_qty)
			{
				$order = new Order();
				$order_total = 0;
				$points_total = 0;
				$lines = [];
				$order_lines = $faker->numberBetween($min = 1, $max = 5);
				for($i = 1; $i <= $order_lines; $i++) {
					$line_qty = $faker->numberBetween($min = 1, $max = 3);
					$product = Product::orderByRaw("RAND()")->first();
					$order_total += $product->price;
					$points_total += $product->points_value;
					$lines[] = Orderline::create([
						'product_id'=> $product->id,
						'name'=> $product->name,
						'price_each'=>$product->price,
						'price_ext'=>$product->price*$line_qty,
						'points_each'=>$product->price,
						'points_ext'=>$product->price*$line_qty,
						'qty'=>$line_qty,
						'created_at'=> $order_date,
						'updated_at'=> $order_date
					]);
					$quantity += $line_qty;
				}
				if(count($lines) > 0)
				{
					$order->total_price = $order_total;
					$order->total_points = $points_total;
					$order->created_at = $order_date;
					$order->updated_at = $order_date;
					$order->save();
					$order->user()->associate($rep);
					$order->lines()->saveMany($lines);
					$order->save();
				}

			}
		}
		$order_date = date('Y-m-d');
		//$reps = User::all();
		//return $reps;
		foreach($reps as $rep)
		{
			$quantity = 0;
			$order_qty = $faker->numberBetween($min = 75, $max = 500);
			while($quantity < $order_qty)
			{
				$order = new Order();
				$order_total = 0;
				$points_total = 0;
				$lines = [];
				$order_lines = $faker->numberBetween($min = 1, $max = 5);
				for($i = 1; $i <= $order_lines; $i++) {
					$line_qty = $faker->numberBetween($min = 1, $max = 3);
					$product = Product::orderByRaw("RAND()")->first();
					$order_total += $product->price;
					$points_total += $product->points_value;
					$lines[] = Orderline::create([
						'product_id'=> $product->id,
						'name'=> $product->name,
						'price_each'=>$product->price,
						'price_ext'=>$product->price*$line_qty,
						'points_each'=>$product->price,
						'points_ext'=>$product->price*$line_qty,
						'qty'=>$line_qty,
						'created_at'=> $order_date,
						'updated_at'=> $order_date
					]);
					$quantity += $line_qty;
				}
				if(count($lines) > 0)
				{
					$order->total_price = $order_total;
					$order->total_points = $points_total;
					$order->created_at = $order_date;
					$order->updated_at = $order_date;
					$order->save();
					$order->user()->associate($rep);
					$order->lines()->saveMany($lines);
					$order->save();
				}

			}
		}
	}

}