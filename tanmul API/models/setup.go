package models

import (
	"gorm.io/driver/mysql"
	"gorm.io/gorm"
)

var DB *gorm.DB

func ConnectDatabase() {
	database, err := gorm.Open(mysql.Open("root:@tcp(localhost:3306)/tanmuldb"))
	if err != nil {
		panic(err)
	}

	database.AutoMigrate(&Pelanggan{})
	database.AutoMigrate(&Info_bar{})
	database.AutoMigrate(&Stok_bar{})
	database.AutoMigrate(&Kiriman{})
	database.AutoMigrate(&Trans_detail{})

	DB = database
}
