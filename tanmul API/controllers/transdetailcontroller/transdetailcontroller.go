package transdetailcontroller

import (
	"net/http"
	"tanmul-api/models"

	"github.com/gin-gonic/gin"
	"github.com/go-playground/validator/v10"
	"gorm.io/gorm"
)

func Index(c *gin.Context) {
	var trans_detail []models.Trans_detail

	models.DB.Find(&trans_detail)

	c.JSON(http.StatusOK, gin.H{
		"status":  true,
		"message": "Data ditemukan",
		"data":    trans_detail,
	})
}

func Show(c *gin.Context) {
	var trans_detail models.Trans_detail
	id := c.Param("id")

	if err := models.DB.First(&trans_detail, id).Error; err != nil {
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
		"data":    trans_detail,
	})
}

func Create(c *gin.Context) {
	var trans_detail models.Trans_detail

	if err := c.ShouldBindJSON(&trans_detail); err != nil {
		c.JSON(http.StatusOK, gin.H{
			"status":  false,
			"message": "Gagal memasukkan data",
			"data":    err.Error(),
		})
		return
	}

	validate := validator.New()
	if err := validate.Struct(trans_detail); err != nil {
		errors := err.(validator.ValidationErrors)
		c.JSON(http.StatusOK, gin.H{
			"status":  false,
			"message": "Tidak dapat menambahkan data",
			"data":    errors.Error(),
		})
		return
	}

	if err := models.DB.Create(&trans_detail).Error; err != nil {
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
	var trans_detail models.Trans_detail
	id := c.Param("id")

	if err := c.ShouldBindJSON(&trans_detail); err != nil {
		c.JSON(http.StatusOK, gin.H{
			"status":  false,
			"message": "Gagal melakukan update data",
			"data":    err.Error(),
		})
		return
	}

	if models.DB.Model(&trans_detail).Where("id_detail = ?", id).Updates(&trans_detail).RowsAffected == 0 {
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
		"data":    trans_detail,
	})
}

func Delete(c *gin.Context) {
	var trans_detail models.Trans_detail

	id := c.Param("id")

	if models.DB.Delete(&trans_detail, id).RowsAffected == 0 {
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
