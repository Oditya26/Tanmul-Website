package models

type Kiriman struct {
	Id_kirim   int64  `gorm:"primaryKey" json:"id_kirim"`
	Tgl_kirim  string `gorm:"type:date" json:"tgl_kirim" binding:"required"`
	Nama_supir string `gorm:"type:varchar(50)" json:"nama_supir" binding:"required"`
	Nama_plg   string `gorm:"type:varchar(50)" json:"nama_plg" binding:"required"`
}

func (Kiriman) TableName() string {
	return "Kiriman"
}
