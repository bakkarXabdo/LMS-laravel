import tkinter as tk
from random import random
from threading import Thread
from time import sleep, time

from PIL import Image, ImageTk, ImageSequence

class Gif:
    def __init__(self, parent, img, Nbr_Round, totalWait, totalCompute,value, x, y, speed=10):
        self.parent = parent
        self.canvas = tk.Canvas(parent, width=200, height=175)
        self.canvas.grid(column=x, row=y, sticky="nesw")
        self.sequence = [ImageTk.PhotoImage(img)
                            for img in ImageSequence.Iterator(Image.open(img+".gif"))]
        self.image = self.canvas.create_image(60, 55, image=self.sequence[1])

        self.Nbr_Round = tk.Label(self.canvas, text=Nbr_Round, bg='black', fg='white').place(x=45, y=108)
        self.totalWait = tk.Label(self.canvas, text="total wait : "+str(totalWait), fg='black').place(x=2, y=129)
        self.totalCompute = tk.Label(self.canvas, text="total compute : "+str(totalCompute), fg='black').place(x=2, y=150)
        self.value = tk.Label(self.canvas, text=value, bg='orange', fg='white').place(x=36, y=5)

        self.speed=speed
        self.animate(1)
    def animate(self, counter):
        self.canvas.itemconfig(self.image, image=self.sequence[counter])
        self.parent.after(100, lambda: self.animate((counter+self.speed) % len(self.sequence)))

    def set_image(self, img):
        self.sequence = [ImageTk.PhotoImage(img)
                         for img in ImageSequence.Iterator(Image.open(img + ".gif"))]

    def set_round(self, Nbr_Round):
        self.Nbr_Round = tkinter.Label(self.canvas, text=Nbr_Round, bg='black', fg='white').place(x=45, y=108)

    def set_totalWait(self, totalWait):
        self.totalWait = tkinter.Label(self.canvas, text="total wait : "+str(totalWait), fg='black').place(x=2, y=129)

    def set_totalCompute(self, totalCompute):
        self.totalCompute = tkinter.Label(self.canvas, text="total compute : "+str(totalCompute), fg='black').place(x=2, y=150)

    def set_value(self, value):
        self.Nbr_Round = tkinter.Label(self.canvas, text=value, bg='orange', fg='white').place(x=36, y=5)

root = tk.Tk()
root.geometry("1200x800")

whiteBoard = tk.Canvas(root, bg='white')
whiteBoard.grid(column=0, row=0, sticky="nesw")

leftSide = tk.Canvas(whiteBoard,  width=200, height=800, bg='orange')
leftSide.grid(column=0, row=0, sticky="nesw")

rightSide = tk.Canvas(whiteBoard,  width=1000, height=800, bg='white')
rightSide.grid(column=2, row=0, sticky="nesw")

gif = r"G:\Downloads\Pictures\166576307_902626117181628_3969872025212468703_n"
Gif(rightSide, gif, 0, 0, 0, 0, 0, 0)
Gif(rightSide, gif, 0, 0, 0, 0, 1, 0)
Gif(rightSide, gif, 0, 0, 0, 0, 2, 0)
Gif(rightSide, gif, 0, 0, 0, 0, 3, 0)

root.mainloop()
