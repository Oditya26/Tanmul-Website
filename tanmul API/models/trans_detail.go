package models

type Trans_detail struct {
	Id_detail    int64  `gorm:"primaryKey" json:"id_detail"`
	Id_kirim     int64  `gorm:"not null;index;foreignKey:Id_kirim;references:Kiriman(Id_kirim)" json:"id_kirim"`
	Nama_bar     string `gorm:"type:varchar(50)" json:"nama_bar" binding:"required"`
	Jml_pcs_jual int64  `gorm:"int" json:"jml_pcs_jual" binding:"required"`
	Hrg_jual     int64  `gorm:"int" json:"hrg_jual" binding:"required"`
	Diskon       int64  `gorm:"int" json:"diskon" binding:"required"`
}

func (Trans_detail) TableName() string {
	return "Trans_detail"
}
