package models

type Info_bar struct {
	Id_bar   int64  `gorm:"primaryKey" json:"id_bar"`
	Nama_bar string `gorm:"type:varchar(50)" json:"nama_bar" binding:"required"`
	Sat_qty  string `gorm:"type:ENUM('bal', 'karton', 'pack')" json:"sat_qty" binding:"required"`
	Pcs      int64  `gorm:"int" json:"pcs" binding:"required"`
	Hrg_jual int64  `gorm:"int" json:"hrg_jual" binding:"required"`
	Hrg_beli int64  `gorm:"int" json:"hrg_beli" binding:"required"`
}

func (Info_bar) TableName() string {
	return "Info_bar"
}
