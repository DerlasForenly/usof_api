namespace App\FileUpload;

use Illuminate\Support\Str;

Trait UserPhoto {

	public function UserFileUpload($file)
	{
		$file_name = uniqid('photo_',true).Str::random(10).'.'.$file->getClientOriginalExtension();

		if($file->isValid()){
			$file->storeAs('images',$file_name);
		}
	}
}
