# -*- coding: utf-8 -*-
from __future__ import unicode_literals

from django.db import models, migrations


class Migration(migrations.Migration):

    dependencies = [
        ('contenttypes', '0002_remove_content_type_name'),
    ]

    operations = [
        migrations.CreateModel(
            name='Movie',
            fields=[
                ('id', models.AutoField(verbose_name='ID', serialize=False, auto_created=True, primary_key=True)),
                ('created_at', models.DateTimeField(auto_now_add=True)),
                ('modified_at', models.DateTimeField(auto_now=True)),
                ('title', models.CharField(max_length=500)),
                ('shortTitle', models.CharField(max_length=200)),
                ('year', models.IntegerField()),
                ('shortSummary', models.CharField(max_length=500, null=True, blank=True)),
                ('summary', models.CharField(max_length=1000)),
                ('startDate', models.DateTimeField()),
                ('endDate', models.DateTimeField()),
                ('language', models.CharField(max_length=10)),
                ('primaryGenre', models.CharField(max_length=50)),
                ('polymorphic_ctype', models.ForeignKey(related_name='polymorphic_movies.movie_set+', editable=False, to='contenttypes.ContentType', null=True)),
            ],
            options={
                'abstract': False,
            },
        ),
    ]
