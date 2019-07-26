import csv
import sys
import mysql.connector
import datetime
from dateutil import parser as dateParser

# create a connection to the database
db = mysql.connector.connect(
    host="localhost",
    user="root",
    passwd="password",
    database="DieLibrary"
)

# Query to insert into the die table
insertDie = """INSERT INTO dies (dieID, datePurchased, flatWidth, flatHeight,
                                  finishedWidth, finishedHeight, numPockets,
                                  pocketSize, machine, location, expectedUsage,
                                  numberUp, dieReviewed, description) 
                VALUES (%(dieID)s, %(datePurchased)s, %(flatWidth)s,
                        %(flatHeight)s, %(finishedWidth)s, %(finishedHeight)s,
                        %(numPockets)s, %(pocketSize)s, %(machine)s, %(location)s,
                        %(expectedUsage)s, %(numberUp)s, %(dieReviewed)s,
                        %(description)s)"""

def logErrorRow(file, row, error):
    file.write(",".join(row + [str(error)]) + "\n")

def correctDate(dateString):
    format = "%Y-%m-%d"

    # Try to get the properly formatted date. Default to 1970-1-1 if error
    try:
        return dateParser.parse(dateString).strftime(format);
    except ValueError:
        return datetime.datetime(1970, 1, 1).strftime(format)

def correctNumber(number, floating=False):
    try:
        if floating:
            return float(number)
        else:
            return int(number)
    except ValueError:
        return None

def correctMachine(machine):
    if not machine:
        return None
    elif machine.lower() == "heid":
        return "Heidelberg"
    return machine

def correctLocation(location, machine):
    if not location:
        return correctMachine(machine)
    return location

def correctExpectedUsage(expectedUsage):
    if not expectedUsage:
        return "Unknown"
    return expectedUsage

def correctDieReviewed(dieReviewed):
    if not dieReviewed:
        return "false"
    return None

# Open a csv and start processing
with open(sys.argv[1], newline='', encoding="latin-1") as file:
    mycursor = db.cursor()
    reader = csv.reader(file, delimiter=",")

    # Open a log file for any rows that have errors
    errorLog = open("error.log", "w+")
    successfulInserts = 0

    # Create a job log to keep record of dies and jobs
    jobLog = open("jobs.log", "w+")
    jobLog.write("jobNumber,dieID,customerName,newDie,jobDate\n")

    # skip the first (headers) and start processing
    next(reader)
    for row in reader:
        dieID, datePurchased, jobNumber, flatWidth, flatHeight, finishedWidth,\
        finishedHeight, numPockets, pocketSize, machine, location,\
        expectedUsage, numberUp, dieReviewed, description, dateModified = row

        # Data from the row (note: the provided import data did not provide
        # tags, they were job numbers, so I extracted them and created
        # a csv for transaction history which can be imported later)
        die = {
            "dieID":          dieID,
            "datePurchased":  correctDate(datePurchased),
            "flatWidth":      correctNumber(flatWidth, True),
            "flatHeight":     correctNumber(flatHeight, True),
            "finishedWidth":  correctNumber(finishedWidth, True),
            "finishedHeight": correctNumber(finishedHeight, True),
            "numPockets":     correctNumber(numPockets),
            "pocketSize":     correctNumber(pocketSize),
            "machine":        correctMachine(machine),
            "location":       correctLocation(location, machine),
            "expectedUsage":  correctExpectedUsage(expectedUsage),
            "numberUp":       correctNumber(numberUp),
            "dieReviewed":    correctDieReviewed(dieReviewed),
            "description":    description
        }

        # Try to insert, if error, log the row
        try:
            mycursor.execute(insertDie, die)
            successfulInserts += 1

            # Record job numbers and put into a csv for importing
            if jobNumber:
                jobLog.write(",".join([jobNumber, dieID]) + ",,,\n")
        except mysql.connector.errors.DatabaseError as e:
            logErrorRow(errorLog, row, e)

    print("Successfully inserted {} dies".format(successfulInserts))

    # cleanup
    errorLog.close()
    jobLog.close()
    db.commit()
    db.close()

