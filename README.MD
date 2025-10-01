Hàm implode()
$fruits = ["Táo", "Chuối", "Cam"];
$result = implode(", ", $fruits);
echo $result; 
Kết quả:
Táo, Chuối, Cam



$names = ["nghia", "trung", "le"];

$capitalized = array_map(function($name) {
    return ucfirst($name); // viết hoa chữ cái đầu
}, $names);

print_r($capitalized);
Kết quả:  
Array
(
    [0] => Nghia
    [1] => Trung
    [2] => Le
)


Hàm array_values bỏ key lấy values