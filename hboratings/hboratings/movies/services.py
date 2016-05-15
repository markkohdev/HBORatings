import urllib, re
from django.conf import settings
import xml.etree.ElementTree as ET

class HBOService():
    """
    This service class will fetch all the things from
    HBO Go
    """
    hbo_url = settings.HBO_MOVIE_LIST_URL
    hbo_file = settings.HBO_DATA_FILENAME

    @classmethod
    def get_movie_elements(cls):
        urllib.urlretrieve(cls.hbo_url, 'hbo_data.xml')

        tree = ET.parse(cls.hbo_file)

        root = tree.getroot()
        body = root.find('body')
        movie_list_container = body.find('productResponses')

        movies = []

        for movie_xml in movie_list_container.iter('featureResponse'):
            movie = cls.convert_xml_to_dict(movie_xml)
            movies.append(movie)

        return movies

    @classmethod
    def convert_xml_to_dict(cls, movie_xml):
        movie = {}

        # All of these fields will map directly to the thing
        direct_nodes = [
            'hboInternalId',
            'title',
            'shortTitle',
            'shortSummary',
            'summary',
            'startDate',
            'endDate',
            'year',
            'language',
            'primaryGenre',
            'genreCode',
        ]

        movie['title'] = movie_xml.find('title').text

        for node in direct_nodes:
            movie[node] = movie_xml.find(node).text

        # Get the thumbnails


        return movie

