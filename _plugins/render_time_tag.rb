require 'date'
Jekyll::Hooks.register :site, :post_read do |site|

  degrees = []
  degree_map = {}

  jobs = []
  job_map = {}
  total_jobs = 0

  genders = []
  gender_map = {}

  total_dates = 0
  dates_sum = 0

  techrangers = site.collections['techrangers_past'].docs | site.collections['techrangers_current'].docs
  techrangers.each do |person|

    # collect degrees
    if person.data['degrees']
      person.data['degrees'].each do |degree|
        if !degree_map.has_key? degree
          thisDegree = {'title' => degree, 'people' => []}
          degrees << thisDegree
          degree_map[degree] = thisDegree
        else
          thisDegree = degree_map[degree]
        end
        thisDegree['people'] << person
      end
    end

    # collect employers
    if person.data['also_employed_by']
      person.data['also_employed_by'].each do |job|
        total_jobs += 1
        if !job_map.has_key?(job)
          thisJob = {'title' => job, 'people' => []}
          jobs << thisJob
          job_map[job] = thisJob
        else
          thisJob = job_map[job]
        end
        thisJob['people'] << person
      end
    end

    # collect gender
    if person.data['gender']
      gender = person.data['gender'].to_s
      if !gender_map.has_key?(gender)
        thisGender = {'title' => gender, 'count' => 0}
        genders << thisGender
        gender_map[gender] = thisGender
      else
        thisGender = gender_map[gender]
      end
      thisGender['count'] += 1
    end

    # collect tenure
    if person.data['date'] && person.data['resigned'] && person.data['resigned'] != '??'
      if person.data['resigned'].kind_of? String
        person.data['resigned'] = Date.strptime(person.data['resigned'], '%Y-%m-%d')
      end
      start_d = Date.parse(person.data['date'].to_s)
      end_d = person.data['resigned']
      total_dates = total_dates + 1
      days_diff = end_d - start_d
      # puts days_diff
      dates_sum = dates_sum + days_diff
    end

  end

  dates_av_days = dates_sum / total_dates

  jobs.sort_by! { |a| a['people'].size }
  degrees.sort_by! { |a| a['people'].size }
  genders.sort_by! { |a| a['count'] }

  site.config['tr'] = {'dates_av_days' => dates_av_days.to_i, 'tr_count' => techrangers.size, 'jobs' => jobs.reverse!, 'total_jobs' => total_jobs, 'degrees' => degrees.reverse!, 'genders' => genders.reverse}
end


module ArraySlice
  def array_slice(input, start, length)
    input.slice(start, length)
  end

  # given an array, compare a paramater of each array hash given an operator
  # all items that evaluate to false will be hidden in an "others" item
  # and appended to the end of the results as others
  # EX {% assign tall_people = array_of_people_hashes | combine_some_into: height, >, 5, 'below 5 feet' %}
  # given an array of hashes like { 'title' => 'Ian', 'height' => 6 }
  # # all items with a hight above 5 will be returned unaltered
  # any item in the array with a key 'height' of a value '>' compared to '5' will be consolidated a single item at the end of the array
  def combine_some_into(input, count_param, operator, compare_to, title)
    compare_to = compare_to
    newOutput = []
    others = { 'title' => title }
    others[count_param] = []

    input.each do |i|
      count = i[count_param].size
      if count.send(operator, compare_to)
        newOutput << i
      else
        others[count_param] += i[count_param]
      end
    end

    newOutput << others
    newOutput
  end
end

Liquid::Template.register_filter(ArraySlice)

