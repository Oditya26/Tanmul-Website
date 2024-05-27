package models

type Stok_bar struct {
	Id_bar     int64 `gorm:"primaryKey;not null;index;foreignKey:Id_bar;references:Info_bar(Id_bar)" json:"id_bar"`
	Stok_aman  int64 `gorm:"int" json:"stok_aman" binding:"required"`
	Stok_now   int64 `gorm:"int" json:"stok_now" binding:"required"`
	Stok_retur int64 `gorm:"int" json:"stok_retur"`
}

func (Stok_bar) TableName() string {
	return "Stok_bar"
}
