for f in data/*;
do
	python db_init.py gslproject_gsl gslnb... <<< $f
done
