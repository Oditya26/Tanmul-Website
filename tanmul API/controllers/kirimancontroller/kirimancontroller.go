package kirimancontroller

import (
	"net/http"
	"tanmul-api/models"

	"github.com/gin-gonic/gin"
	"github.com/go-playground/validator/v10"
	"gorm.io/gorm"
)

func Index(c *gin.Context) {
	var kiriman []models.Kiriman

	models.DB.Find(&kiriman)

	c.JSON(http.StatusOK, gin.H{
		"status":  true,
		"message": "Data ditemukan",
		"data":    kiriman,
	})
}

func Show(c *gin.Context) {
	var kiriman models.Kiriman
	id := c.Param("id")

	if err := models.DB.First(&kiriman, id).Error; err != nil {
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
		"data":    kiriman,
	})
}

func Create(c *gin.Context) {
	var kiriman models.Kiriman

	if err := c.ShouldBindJSON(&kiriman); err != nil {
		c.JSON(http.StatusOK, gin.H{
			"status":  false,
			"message": "Gagal memasukkan data",
			"data":    err.Error(),
		})
		return
	}

	validate := validator.New()
	if err := validate.Struct(kiriman); err != nil {
		errors := err.(validator.ValidationErrors)
		c.JSON(http.StatusOK, gin.H{
			"status":  false,
			"message": "Tidak dapat menambahkan data",
			"data":    errors.Error(),
		})
		return
	}

	if err := models.DB.Create(&kiriman).Error; err != nil {
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
	var kiriman models.Kiriman
	id := c.Param("id")

	if err := c.ShouldBindJSON(&kiriman); err != nil {
		c.JSON(http.StatusOK, gin.H{
			"status":  false,
			"message": "Gagal melakukan update data",
			"data":    err.Error(),
		})
		return
	}

	if models.DB.Model(&kiriman).Where("id_kirim = ?", id).Updates(&kiriman).RowsAffected == 0 {
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
		"data":    kiriman,
	})
}

func Delete(c *gin.Context) {
	var kiriman models.Kiriman

	id := c.Param("id")

	if models.DB.Delete(&kiriman, id).RowsAffected == 0 {
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
