package models

type Pelanggan struct {
	Id_plg       int64  `gorm:"primaryKey" json:"id_plg"`
	Nama_plg     string `gorm:"type:varchar(50)" json:"nama_plg" binding:"required"`
	Telp_plg     string `gorm:"type:varchar(15)" json:"telp_plg" binding:"required"`
	Alamat_utama string `gorm:"type:varchar(100)" json:"alamat_utama" binding:"required"`
}

type Tabler interface {
	TableName() string
}

func (Pelanggan) TableName() string {
	return "Pelanggan"
}
