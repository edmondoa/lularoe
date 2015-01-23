<?php
 
class ProductTagController extends \BaseController {
 
    /**
     * Remove the specified productTag from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        ProductTag::destroy($id);
    }
 
}