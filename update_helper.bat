echo off

echo off
echo "Language"
mkdir app\Language\pt-BR
copy ..\Brapci3.1\app\Language\pt-BR\social.* app\Language\pt-BR\*.*

echo "Copiando Helper"
copy ..\Brapci3.1\app\Helpers\*.* app\Helpers\*.*
copy ..\Brapci3.1\app\Models\Social*.* app\Models\*.*
copy ..\Brapci3.1\app\Database\Migrations\2022-08-29-005637_Users.php app\Database\Migrations\*.*
copy ..\Brapci3.1\app\Database\Migrations\2022-09-15-015104_UsersLog.php app\Database\Migrations\*.*

#echo "RDP"
#mkdir app\Models\Rdf

#copy ..\Brapci3.1\app\Models\RDF\RDF*.php app\Models\RDF\*.*

echo "Images"
copy ..\Brapci3.1\app\Models\Images.php app\Models\*.*

echo "CSS"
copy ..\Brapci3.1\public\css\style_sisdoc.css public\css\*.*

echo "IO"
mkdir app\Models\Io
copy ..\Brapci3.1\app\Models\Io\*.php app\Models\Io\*.*
