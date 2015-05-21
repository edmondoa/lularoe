<?php
use League\Csv\Reader;
use League\Csv\Writer;
/*##############################################################################################
mysqldump -uroot -p cp-iap addresses phones users items products product_item > IAP_data.sql
mysqldump -uroot -p cp-iap items products product_item > IAP_product_data.sql
##############################################################################################*/

class ImportController extends \BaseController {

	private $not_found = 0;
	/**
	 * Importation of orders for commission checking.
	 * GET /import/products
	 *
	 * @return Response
	 */
	public function getProducts()
	{
		$reader = Reader::createFromPath(app_path().'/storage/temp/product.csv');
		/*##############################################################################################
		SET FOREIGN_KEY_CHECKS=0;
		TRUNCATE products; 
		TRUNCATE product_tags; 
		SET FOREIGN_KEY_CHECKS=1;		
		[0] => name
		[1] => orderItemCount
		[2] => orderValue
		[3] => orderItemCount

		##############################################################################################*/
		
/*		$reader->setDelimiter(',');
		$reader->setEnclosure('"');
		$reader->setEscape('\\');
*/		
$styles =
	[
		'Irma'=>'201',
		'Randy'=>'202',
		'Sloan'=>'203',
		'Monroe'=>'204',
		'Azure'=>'301',
		'Cassie'=>'302',
		'Leggings'=>'303',
		'Lola'=>'304',
		'Lucy'=>'305',
		'Madison'=>'306',
		'Maxi'=>'307',
		'Kid’s Cassi'=>'308',
		'Kid’s Maxi'=>'309',
		'Amelia'=>'401',
		'Ana'=>'402',
		'Julia'=>'403',
		'Nicole'=>'404',
		'Dot Dot Lucy w/ slvs'=>'405',
		'Dot dot Lucy tank'=>'406',
	];
$sizes = 
	[
		'XXS'=>'1',
		'XS'=>'2',
		'S'=>'3',
		'M'=>'4',
		'L'=>'5',
		'XL'=>'6',
		'2XL'=>'7',
		'3XL'=>'8',
		'2'=>'9',
		'4'=>'10',
		'6'=>'11',
		'8'=>'12',
		'10'=>'13',
		'12'=>'14',
		'14'=>'15',
		'3/4'=>'16',
		'5/6'=>'17',
		'8/10'=>'18',
		'S/M'=>'19',
		'L/XL'=>'20',
		'Tween'=>'21',
		'One size'=>'22',
		'T/C'=>'23',
	];
$colors =
	[
		'AZT'=>'900',
		'CLB'=>'901',
		'FLR'=>'902',
		'GEO'=>'903',
		'SLD'=>'904',
		'STR'=>'905',
	];
		$reader->setOffset(1);
		//$data = $reader->fetchOne();
		//return dd($data);
		$reader->each(function ($row, $index, $iterator) {
			
			//$tags = explode(" ",$row[0]);
			if(count($row)!=3)
			{
				echo "<h2>OOPS</h2>";
				return true;
			}

			//echo"<pre>"; print_r($row); echo"</pre>";
			//return true;
			$style = '';
			$size = '';
			$color = '';

			$style = $styles[$row[0]];
			$size = $sizes[$row[1]];
			$color = $colors[$row[2]];
			$sku = $style."-".$size."-".$color;
			echo"<pre>"; print_r($sku); echo"</pre>";
			return true;
			$product = Product::create([
				'name' => $row[0]." ".$row[1]." ".$row[2],
				//'blurb' => '',
				//'description' => '',
				'price' => 0.00,
				'points_value' => 20,
				'sku'=> '',
				//'quantity' => $faker->randomDigitNotNull,
				//'category_id' => $faker->randomDigitNotNull,
				//'disabled' => $faker->boolean,
			]);
			$product->sku = $product->id;
			$product->save();
			foreach($row as $tag)
			{
				$new_tag = ProductTag::create([
					'name'=> $tag
				]);
				$product->tags()->save($new_tag);
			}
			if(true)    
			{
				return true;
			}
			else
			{
				//echo"<pre>"; print_r($item); echo"</pre>";
				echo"<pre>"; print_r($row); echo"</pre>";
			}
			return false;
		});
		return 'Not Found:'.$this->not_found;
	}
	/**
	 * Importation of orders for commission checking.
	 * GET /import/orders
	 *
	 * @return Response
	 */
	public function getOrders()
	{
		$reader = Reader::createFromPath(app_path().'/storage/temp/january_compensation.csv');
		/*##############################################################################################
		[0] => name
		[1] => orderItemCount
		[2] => orderValue
		[3] => orderItemCount
		##############################################################################################*/
		
/*		$reader->setDelimiter(',');
		$reader->setEnclosure('"');
		$reader->setEscape('\\');
*/		
		//$reader->setOffset(1);
		//$data = $reader->fetchOne();
		//return dd($data);
		$reader->each(function ($row, $index, $iterator) {
			if(count($row) != 4)
			{
				\Log::info('IMPORT:ORDERS - Failed to import this data'.serialize($row));
				return true;
			}
			//exit('made it to the end');
/*			if(count($row)!=6)
			{
				echo"<pre>"; print_r($row); echo"</pre>";
				return false;
			}
*/			
			$name_parts = explode(" ",trim($row[0]));
			if(count($name_parts) == 3)
			{
				$first = $name_parts[0]." ".$name_parts[1];
				$last = $name_parts[2];
			}
			elseif(in_array("&",$name_parts))
			{
				$first = $name_parts[0];
				$last = $name_parts[count($name_parts)-1];
			}
			else
			{
				$first = $name_parts[0];
				$last = $name_parts[1];
			}
			//$row[4] = $name_parts;
			$rep = User::whereRaw("CONCAT_WS(' ',first_name,last_name)= :value",['value'=>$row[0]])->first();
			if(isset($rep->id))
			{
				$row[4] = $rep->id;
			}
			else
			{
				$reps = User::where('last_name',$last)->get();
				foreach($reps as $rep)
				{
					echo"<li>".$rep->first_name." ".$rep->last_name."</li>";
				}
/*				if($reps->count() ==1)
				{
					$row[4] = $reps[0]->id;
				}
				else
				{
					//echo"<ul>";
					foreach($reps as $rep)
					{
						echo"<li>".$rep->last_name.", ".$rep->first_name."</li>";
					}
					//echo"</ul>";
					//echo"<pre>"; print_r($name_parts); echo"</pre>";
					echo"<pre>"; print_r($row[0]); echo"</pre>";
				}
*/				echo"<pre>"; print_r($row[0]); echo"</pre>";
				$this->not_found ++;
			}
			//echo"<pre>"; print_r($row); echo"</pre>";
			return true;
			$item = Item::create([
				'control_number'=> $row[1],
				'name'=>$row[2],
				'description'=>$row[3],
				'qty_available'=> (int) $row[4],
				'qty_staged'=> (int) $row[5],
				'disabled'=> ($row[0] >0)?true:false
			]);
			if($item)    
			{
				return true;
			}
			else
			{
				echo"<pre>"; print_r($item); echo"</pre>";
				echo"<pre>"; print_r($row); echo"</pre>";
			}
			return false;
		});
		return 'Not Found:'.$this->not_found;
	}
	/**
	 * Importation of orders for commission checking.
	 * GET /import/consultants
	 *
	 * @return Response
	 */
	public function getConsultants()
	{
		$reader = Reader::createFromPath(app_path().'/storage/temp/reps.csv');
		/*##############################################################################################
		SET FOREIGN_KEY_CHECKS=0;
		TRUNCATE users; 
		SET FOREIGN_KEY_CHECKS=1;

	[0] => ID
	[1] => Created
	[2] => FirstName
	[3] => Surname
	[4] => Email
	[5] => Address
	[6] => AddressLine2
	[7] => City
	[8] => State
	[9] => Zip
	[10] => Country
	[11] => Phone
	[12] => MemberStatus
	[13] => SponsorID
		[0] => ID
		[1] => Created
		[2] => FirstName
		[3] => Surname
		[4] => Email
		[5] => Address
		[6] => AddressLine2
		[7] => City
		[8] => Country
		[9] => Phone
		[10] => SkypeID
		[11] => MemberStatus
		[12] => SponsorID
		##############################################################################################*/
	
		$reader->setOffset(1);
		//$data = $reader->fetchOne();
		//return dd($data);
		$reader->each(function ($row, $index, $iterator) {
			//exit('made it to the end');
			//echo"<pre>"; print_r($row); echo"</pre>";
			//return true;
			//$name_parts = explode(" ",$row[0]);
			//$row[4] = $name_parts;
/*
			$rep = User::where('first_name',$name_parts[0])->where('last_name',$name_parts[1])->first();
			if(isset($rep->id))
			{
				$row[4] = $rep->id;
			}
			else
			{
				$reps = User::where('last_name',$name_parts[1])->get();
				foreach($reps as $rep)
				{
					echo"<pre>"; print_r($rep->toArray()); echo"</pre>";
				}
			}
*/			
			$user = User::firstOrNew(['id'=>$row[0]]);
			$user->id = $row[0];
			$user->timestamps = false;
			$user->first_name = $row[2];
			$user->last_name = $row[3];
			$user->created_at = date('Y-m-d',strtotime($row[1]));
			$user->updated_at = $user->created_at;
			$user->email = $row[4];
			$user->sponsor_id = $row[13];
			$user->original_sponsor_id = $row[13];
			$user->save();
			//$user-> = $row[];
			//echo"<pre>"; print_r($user->toArray()); echo"</pre>";
			return true;
			echo"<pre>"; print_r($row); echo"</pre>";
		});
		$admin = User::find(10095);
		$admin->password = Hash::make('1234');
		$admin->sponsor_id = null;
		$admin->original_sponsor_id = null;
		$admin->save();
		return 'thats that';
	}
	public function getFixLedger()
	{
		$reader = Reader::createFromPath(app_path().'/storage/temp/receipt_fixes.csv');
		/*##############################################################################################

		[0] => receipt_id
		[1] => date
		[2] => original_amount
		[3] => tax
		[4] => first_name
		[5] => last_name
		[6] => notes
		[7] => original_payment_info
		[8] => refNum
		[9] => payment_amount
		[10] => user_id
		[11] => tpe
		[12] => Existing_ledger_id
		[13] => 

		##############################################################################################*/
	
		$reader->setOffset(1);
		//$data = $reader->fetchOne();
		//return dd($data);
		$reader->each(function ($row, $index, $iterator) {
			$receipt = Receipt::findOrFail($row[0]);
			$user = User::where('email',$receipt->to_email)->first();
			if(!is_null($user))
			{
				//echo"<pre>"; print_r($user->toArray()); echo"</pre>";
			}
			else
			{
				$user = User::where('last_name',$receipt->to_lastname)->where('first_name',$receipt->to_firstname)->first();
				if(!is_null($user))
				{
					//echo"<pre>"; print_r($user->toArray()); echo"</pre>";
				}
				else
				{
					echo "<p>-- User not found for ".$receipt->to_lastname." ".$receipt->to_firstname."</p>";
					$user = new stdClass;
					$user->id= "unknown";
					//echo"<pre>"; print_r($receipt->toArray()); echo"</pre>";
					//echo"<pre>"; print_r($row); echo"</pre>";
					return true;
				}
			}
			//echo"<pre>"; print_r($receipt->toArray()); echo"</pre>";
			//echo"<pre>"; print_r($row); echo"</pre>";
			// /exit;
			//return true;

			if((!empty($row[12]))&&(is_numeric($row[12])))
			{
				echo "UPDATE ledger SET receipt_id=".$row[12]." WHERE id = ".$row[0].";<br />";
				//$ledger = Ledger::findOrFail($row[12]);
			}
			elseif(is_numeric($row[8]))
			{
				$countem = Ledger::where('transactionid',$row[8])->count();
				if($countem == 1)
				{
					$ledger = Ledger::where('transactionid',$row[8])->first();
					echo "UPDATE ledger SET receipt_id=".$receipt->id." WHERE id = ".$ledger->id.";<br />";
				}
				else
				{
					//$receipt_date = substr($receipt->created_at,0,10);
					//echo"<pre>"; print_r($receipt_date); echo"</pre>";
					$ledger_by_date_and_amount = Ledger::where('amount',$receipt->subtotal)->whereRaw('LEFT(created_at,10) = ?', ["$row[1]"])->get();
					if(count($ledger_by_date_and_amount->toArray()) > 0)
					{
						$ledger1 = $ledger_by_date_and_amount[0];
						echo "UPDATE ledger SET receipt_id=".$receipt->id." WHERE id = ".$ledger1->id.";<br />";
						//echo "<p>Ledger was found</p>";
						//echo"<pre>"; print_r($ledger1->toArray()); echo"</pre>";
					}
					else
					{
						//echo "<p>It seems we can't find any matching records, so let's create a new one like this</p>";
						$new_ledger = new Ledger;
						$new_ledger->timestamps = false;
						$new_ledger->receipt_id = $receipt->id;
						$new_ledger->amount = $row[9];
						$new_ledger->txtype = $row[11];
						$new_ledger->created_at = $receipt->created_at;
						$new_ledger->updated_at = date('Y-m-d H:i:s');
						$new_ledger->transactionid = $user->id.'-'.strtotime($receipt->created_at);
						echo "INSERT INTO ledger (`amount`,`txtype`,`receipt_id`,`created_at`,`updated_at`,`transactionid`) VALUES 
						('".$row[9]."','".$row[11]."','".$receipt->id."','".$receipt->created_at."','".date('Y-m-d H:i:s')."','".$user->id.'-'.strtotime($receipt->created_at)."');<br />";
						//$new_ledger->save();

						//echo"<pre>"; print_r($new_ledger->toArray()); echo"</pre>";
					}
				}
				//echo"<pre>"; print_r($ledger->toArray()); echo"</pre>";
				//echo "UPDATE ledger SET receipt_id=".$ledger->id." WHERE id = ".$row[0].";<br />";
			}
			else
			{
				//echo "<p>This is a consignment record</p>";
				$new_ledger = new Ledger;
				$new_ledger->timestamps = false;
				$new_ledger->receipt_id = $receipt->id;
				$new_ledger->amount = $row[9];
				$new_ledger->txtype = $row[11];
				$new_ledger->created_at = $receipt->created_at;
				$new_ledger->updated_at = date('Y-m-d H:i:s');
				$new_ledger->transactionid = $user->id.'-'.strtotime($receipt->created_at);
				//$new_ledger->save();
				echo "INSERT INTO ledger (`amount`,`txtype`,`receipt_id`,`created_at`,`updated_at`,`transactionid`) VALUES 
				('".$row[9]."','".$row[11]."','".$receipt->id."','".$receipt->created_at."','".date('Y-m-d H:i:s')."','".$user->id.'-'.strtotime($receipt->created_at)."');<br />";

				//echo"<pre>"; print_r($new_ledger->toArray()); echo"</pre>";

			}
			// /echo"<pre>"; print_r($row); echo"</pre>";
			return true;
			echo"<pre>"; print_r($row); echo"</pre>";
		});
		return 'Fixed Ledger';
	}


}