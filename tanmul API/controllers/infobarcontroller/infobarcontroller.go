package infobarcontroller

import (
	"net/http"
	"tanmul-api/models"

	"github.com/gin-gonic/gin"
	"github.com/go-playground/validator/v10"
	"gorm.io/gorm"
)

func Index(c *gin.Context) {
	var infobar []models.Info_bar

	models.DB.Find(&infobar)

	c.JSON(http.StatusOK, gin.H{
		"status":  true,
		"message": "Data ditemukan",
		"data":    infobar,
	})
}

func Show(c *gin.Context) {
	var infobar models.Info_bar
	id := c.Param("id")

	if err := models.DB.First(&infobar, id).Error; err != nil {
		switch err {
		case gorm.ErrRecordNotFound:
			c.JSON(http.StatusOK, gin.H{
				"status":  false,
				"message": "Data tidak ditemukan",
			})
			return
		default:
			c.JSON(http.StatusOK, gin.H{
				"status":  false,
				"message": err.Error(),
			})
		}
	}

	c.JSON(http.StatusOK, gin.H{
		"status":  true,
		"message": "Data ditemukan",
		"data":    infobar,
	})
}

func Create(c *gin.Context) {
	var infobar models.Info_bar

	if err := c.ShouldBindJSON(&infobar); err != nil {
		c.JSON(http.StatusOK, gin.H{
			"status":  false,
			"message": "Gagal memasukkan data",
			"data":    err.Error(),
		})
		return
	}

	validate := validator.New()
	if err := validate.Struct(infobar); err != nil {
		errors := err.(validator.ValidationErrors)
		c.JSON(http.StatusOK, gin.H{
			"status":  false,
			"message": "Tidak dapat menambahkan data",
			"data":    errors.Error(),
		})
		return
	}

	if err := models.DB.Create(&infobar).Error; err != nil {
		c.JSON(http.StatusOK, gin.H{
			"status":  false,
			"message": "Gagal memasukkan data",
			"data":    err.Error(),
		})
		return
	}

	c.JSON(http.StatusOK, gin.H{
		"status":  true,
		"message": "Sukses memasukkan data",
	})
}

func Update(c *gin.Context) {
	var infobar models.Info_bar
	id := c.Param("id")

	if err := c.ShouldBindJSON(&infobar); err != nil {
		c.JSON(http.StatusOK, gin.H{
			"status":  false,
			"message": "Gagal melakukan update data",
			"data":    err.Error(),
		})
		return
	}

	if models.DB.Model(&infobar).Where("id_bar = ?", id).Updates(&infobar).RowsAffected == 0 {
		c.JSON(http.StatusOK, gin.H{
			"status":  false,
			"message": "Tidak ada perubahan",
			"data":    "Tidak ada perubahan",
		})
		return
	}

	c.JSON(http.StatusOK, gin.H{
		"status":  true,
		"message": "Sukses melakukan update data",
		"data":    infobar,
	})
}

func Delete(c *gin.Context) {
	var infobar models.Info_bar

	id := c.Param("id")

	if models.DB.Delete(&infobar, id).RowsAffected == 0 {
		c.JSON(http.StatusOK, gin.H{
			"status":  false,
			"message": "tidak dapat menghapus data",
		})
		return
	}

	c.JSON(http.StatusOK, gin.H{
		"status":  true,
		"message": "Sukses melakukan delete data",
	})
}
