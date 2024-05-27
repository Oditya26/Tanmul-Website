package main

import (
	"tanmul-api/controllers/infobarcontroller"
	"tanmul-api/controllers/kirimancontroller"
	"tanmul-api/controllers/pelanggancontroller"
	"tanmul-api/controllers/stokbarcontroller"
	"tanmul-api/controllers/transdetailcontroller"
	"tanmul-api/models"

	"github.com/gin-gonic/gin"
)

func main() {
	r := gin.Default()

	models.ConnectDatabase()

	r.GET("/api/pelanggan", pelanggancontroller.Index)
	r.GET("/api/pelanggan/:id", pelanggancontroller.Show)
	r.POST("/api/pelanggan", pelanggancontroller.Create)
	r.PUT("/api/pelanggan/:id", pelanggancontroller.Update)
	r.DELETE("/api/pelanggan/:id", pelanggancontroller.Delete)

	r.GET("/api/infobar", infobarcontroller.Index)
	r.GET("/api/infobar/:id", infobarcontroller.Show)
	r.POST("/api/infobar", infobarcontroller.Create)
	r.PUT("/api/infobar/:id", infobarcontroller.Update)
	r.DELETE("/api/infobar/:id", infobarcontroller.Delete)

	r.GET("/api/stokbar", stokbarcontroller.Index)
	r.GET("/api/stokbar/:id", stokbarcontroller.Show)
	r.POST("/api/stokbar", stokbarcontroller.Create)
	r.PUT("/api/stokbar/:id", stokbarcontroller.Update)
	r.DELETE("/api/stokbar/:id", stokbarcontroller.Delete)

	r.GET("/api/kiriman", kirimancontroller.Index)
	r.GET("/api/kiriman/:id", kirimancontroller.Show)
	r.POST("/api/kiriman", kirimancontroller.Create)
	r.PUT("/api/kiriman/:id", kirimancontroller.Update)
	r.DELETE("/api/kiriman/:id", kirimancontroller.Delete)

	r.GET("/api/transdetail", transdetailcontroller.Index)
	r.GET("/api/transdetail/:id", transdetailcontroller.Show)
	r.POST("/api/transdetail", transdetailcontroller.Create)
	r.PUT("/api/transdetail/:id", transdetailcontroller.Update)
	r.DELETE("/api/transdetail/:id", transdetailcontroller.Delete)

	r.Run()
}
