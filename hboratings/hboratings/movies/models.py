from django.db import models
from polymorphic import PolymorphicModel

class BaseModel(models.Model):
    created_at = models.DateTimeField(auto_now_add=True)
    modified_at = models.DateTimeField(auto_now=True)

    class Meta:
        abstract = True

    def _type(self):
        return self.__class__.__name__

class PolymorphicBaseModel(PolymorphicModel, BaseModel):

    class Meta:
        abstract = True

class Movie(PolymorphicBaseModel):
    title = models.CharField(max_length=500)
    shortTitle = models.CharField(max_length=200)
    year = models.IntegerField()
    shortSummary = models.CharField(max_length=500, null=True, blank=True)
    summary = models.CharField(max_length=1000)
    startDate = models.DateTimeField()
    endDate = models.DateTimeField()
    language = models.CharField(max_length=10)
    primaryGenre = models.CharField(max_length=50)
